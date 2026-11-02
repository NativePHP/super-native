package com.nativephp.plugins.skia

import androidx.test.platform.app.InstrumentationRegistry
import android.graphics.BitmapFactory
import android.graphics.pdf.PdfRenderer
import android.os.ParcelFileDescriptor
import org.junit.Assert.*
import org.junit.Test
import java.io.File

class SkiaIntegrationTest {
    private val instrumentation = InstrumentationRegistry.getInstrumentation()
    private fun scene(index: Int): String {
        val json = instrumentation.context.assets.open("skia/$index.json").bufferedReader().use { it.readText() }
        if (index != 14) return json
        val font = instrumentation.context.assets.open("skia/font.ttf").use { it.readBytes() }
        val data = org.json.JSONObject(json)
        data.getJSONObject("assets").put("editorial", org.json.JSONObject().put("type", "font").put("data", android.util.Base64.encodeToString(font, android.util.Base64.NO_WRAP)))
        data.getJSONArray("nodes").getJSONObject(1).getJSONObject("textStyle").put("font", "editorial")
        return data.toString()
    }

    @Test fun everyChapterExportsThroughTheNativeBridge() {
        val bridge = SkiaFunctions.Export(instrumentation.targetContext)
        for (chapter in 0..30) {
            val result = bridge.execute(mapOf("scene" to scene(chapter), "format" to "png", "width" to 360, "height" to 300, "quality" to 95, "seconds" to 0.75))
            assertEquals("Chapter $chapter: $result", true, result["success"])
            val file = File(result["path"] as String)
            try {
                val bitmap = BitmapFactory.decodeFile(file.absolutePath)
                assertNotNull("Chapter $chapter decodes", bitmap)
                assertEquals(360, bitmap.width); assertEquals(300, bitmap.height)
                bitmap.recycle()
            } finally { file.delete() }
        }
        for (format in listOf("jpeg", "webp", "pdf")) {
            val result = bridge.execute(mapOf("scene" to scene(17), "format" to format, "width" to 1080, "height" to 900, "quality" to 90, "seconds" to 1.0))
            assertEquals(result.toString(), true, result["success"])
            val file = File(result["path"] as String)
            try {
                if (format == "pdf") {
                    ParcelFileDescriptor.open(file, ParcelFileDescriptor.MODE_READ_ONLY).use { descriptor ->
                        PdfRenderer(descriptor).use { pdf ->
                            assertEquals(1, pdf.pageCount)
                            pdf.openPage(0).use { page -> assertEquals(1080, page.width); assertEquals(900, page.height) }
                        }
                    }
                } else {
                    val bitmap = BitmapFactory.decodeFile(file.absolutePath)
                    assertNotNull(bitmap); assertEquals(1080, bitmap.width); assertEquals(900, bitmap.height); bitmap.recycle()
                }
            } finally { file.delete() }
        }
    }

    @Test fun everyCommercialAndShowcaseExampleExports() {
        val bridge = SkiaFunctions.Export(instrumentation.targetContext)
        val names = (0..17).map { "commercial-$it" } + (0..3).map { "showcase-$it" }
        for (name in names) {
            val json = instrumentation.context.assets.open("skia/$name.json").bufferedReader().use { it.readText() }
            val result = bridge.execute(mapOf("scene" to json, "format" to "png", "width" to 360, "height" to 440, "seconds" to 1.5))
            assertEquals("$name: $result", true, result["success"])
            val file = File(result["path"] as String)
            try {
                val bitmap = BitmapFactory.decodeFile(file.absolutePath)
                assertNotNull("$name decodes", bitmap)
                assertEquals(360, bitmap.width)
                assertEquals(440, bitmap.height)
                bitmap.recycle()
            } finally { file.delete() }
        }
    }

    @Test fun animationAndGestureStateWorkOnAndroid() {
        val engine = SkiaNative.create()
        try {
            assertTrue(SkiaNative.setScene(engine, scene(16)))
            assertEquals(7, SkiaNative.gestures(engine))
            assertEquals("planet", SkiaNative.hitTest(engine, 255f, 132f, 0.0))
            assertTrue(SkiaNative.gesture(engine, 0, 360f, 300f, 0, 30f, 0f, 0.0))
            assertEquals("planet", SkiaNative.hitTest(engine, 285f, 132f, 0.0))
            assertTrue(SkiaNative.setScene(engine, scene(16)))
            assertEquals("planet", SkiaNative.hitTest(engine, 285f, 132f, 0.0))
            for (chapter in listOf(13, 15)) {
                assertTrue(SkiaNative.setScene(engine, scene(chapter)))
                val a = android.graphics.Bitmap.createBitmap(360, 300, android.graphics.Bitmap.Config.ARGB_8888)
                val b = android.graphics.Bitmap.createBitmap(360, 300, android.graphics.Bitmap.Config.ARGB_8888)
                try {
                    assertTrue(SkiaNative.render(engine, a, 0.0, 0))
                    assertTrue(SkiaNative.render(engine, b, 0.75, 0))
                    assertFalse("Chapter $chapter animates", a.sameAs(b))
                } finally { a.recycle(); b.recycle() }
            }
            assertFalse(SkiaNative.setScene(engine, "{bad"))
            assertTrue(SkiaNative.error(engine).isNotEmpty())
        } finally { SkiaNative.destroy(engine) }
    }
    @Test fun captureInkAndSemanticsSurviveNativeUpdates() {
        val engine=SkiaNative.create()
        try {
            assertTrue(SkiaNative.setScene(engine,scene(29)))
            assertEquals(8,SkiaNative.gestures(engine))
            fun command(json: String)=org.json.JSONObject(SkiaNative.command(engine,json,0.0))
            assertTrue(command("""{"action":"pointer","phase":"down","pointer":1,"x":50,"y":120,"pressure":0.2,"when":1}""").getBoolean("captured"))
            assertTrue(command("""{"action":"pointer","phase":"move","pointer":1,"x":300,"y":220,"pressure":1,"when":1.1}""").getBoolean("captured"))
            command("""{"action":"pointer","phase":"up","pointer":1,"x":320,"y":230,"pressure":1,"when":1.2}""")
            assertEquals(3,command("""{"action":"state"}""").getJSONObject("ink").getJSONArray("ink-surface").length())
            val items=command("""{"action":"semantics","width":600,"height":440}""").getJSONArray("items")
            assertEquals("Drawing paper",items.getJSONObject(0).getString("label"))
            val file=File(instrumentation.targetContext.cacheDir,"ink-vector-test.pdf")
            assertTrue(SkiaNative.exportFrame(engine,file.absolutePath,600,440,"pdf",90,0.0,0))
            try {
                val bytes=file.readText(Charsets.ISO_8859_1);assertTrue(bytes.contains("NativePHP Skia vector output"));assertFalse(bytes.contains("/Subtype /Image"))
                ParcelFileDescriptor.open(file,ParcelFileDescriptor.MODE_READ_ONLY).use { descriptor -> PdfRenderer(descriptor).use { pdf -> pdf.openPage(0).use { page -> val bitmap=android.graphics.Bitmap.createBitmap(600,440,android.graphics.Bitmap.Config.ARGB_8888);page.render(bitmap,null,null,PdfRenderer.Page.RENDER_MODE_FOR_DISPLAY);assertNotEquals(android.graphics.Color.TRANSPARENT,bitmap.getPixel(100,140));bitmap.recycle() } } }
            } finally {file.delete()}
            command("""{"action":"undoInk","id":"ink-surface"}""")
            assertEquals(0,command("""{"action":"state"}""").getJSONObject("ink").getJSONArray("ink-surface").length())
            repeat(30) { assertTrue(SkiaNative.setScene(engine,scene(it%31))) }
        } finally {SkiaNative.destroy(engine)}
    }

    @Test fun viewCapturesRealMotionEventsAndExportsLiveInk() {
        val context = instrumentation.targetContext
        val intent = context.packageManager.getLaunchIntentForPackage(context.packageName)!!
        intent.addFlags(android.content.Intent.FLAG_ACTIVITY_NEW_TASK)
        val activity = instrumentation.startActivitySync(intent)
        lateinit var view: SkiaView
        instrumentation.runOnMainSync {
            view = SkiaView(activity)
            (activity.findViewById<android.view.ViewGroup>(android.R.id.content)).addView(view, android.view.ViewGroup.LayoutParams(600, 440))
            view.configure(scene(29), "", "contain", false, true, "skia-view-test", 0, 0)
        }
        try {
            var ready = false
            repeat(50) {
                if (!ready) {
                    val result = SkiaCanvases.perform("skia-view-test") { it.control("""{"action":"state"}""") }
                    ready = result["success"] == true
                    if (!ready) Thread.sleep(100)
                }
            }
            assertTrue("Attached native canvas becomes available", ready)
            instrumentation.waitForIdleSync()
            val down = android.os.SystemClock.uptimeMillis()
            instrumentation.runOnMainSync {
                for ((action, point) in listOf(android.view.MotionEvent.ACTION_DOWN to (50f to 120f), android.view.MotionEvent.ACTION_MOVE to (300f to 220f), android.view.MotionEvent.ACTION_UP to (350f to 230f))) {
                    val event = android.view.MotionEvent.obtain(down, android.os.SystemClock.uptimeMillis(), action, point.first, point.second, 0)
                    try { assertTrue(view.dispatchTouchEvent(event)) } finally { event.recycle() }
                }
            }
            val state = SkiaFunctions.Control(context).execute(mapOf("canvasId" to "skia-view-test", "command" to """{"action":"state"}"""))
            assertEquals(3, (state["ink"] as org.json.JSONObject).getJSONArray("ink-surface").length())
            instrumentation.waitForIdleSync()
            instrumentation.runOnMainSync {
                val provider = view.accessibilityNodeProvider!!
                val paper = provider.createAccessibilityNodeInfo(0)!!
                assertEquals("Drawing paper", paper.contentDescription.toString())
                assertTrue(paper.actionList.any { it.label == "undo" })
            }
            val result = SkiaFunctions.Export(context).execute(mapOf("canvasId" to "skia-view-test", "format" to "png", "width" to 600, "height" to 440))
            assertEquals(result.toString(), true, result["success"])
            File(result["path"] as String).delete()
        } finally {
            instrumentation.runOnMainSync { (view.parent as? android.view.ViewGroup)?.removeView(view); view.release() }
        }
        assertTrue(SkiaFunctions.Control(context).execute(mapOf("canvasId" to "skia-view-test", "command" to """{"action":"state"}""")).containsKey("error"))
    }


    @Test fun animationPauseAndRepeatedViewReattachmentRecover() {
        val context = instrumentation.targetContext
        val intent = context.packageManager.getLaunchIntentForPackage(context.packageName)!!
        intent.addFlags(android.content.Intent.FLAG_ACTIVITY_NEW_TASK)
        val activity = instrumentation.startActivitySync(intent)
        val id = "skia-lifecycle-test"
        val json = scene(13)
        lateinit var view: SkiaView
        lateinit var parent: android.view.ViewGroup
        fun state() = SkiaFunctions.Control(context).execute(mapOf("canvasId" to id, "command" to """{"action":"state"}"""))
        fun waitReady() {
            for (attempt in 0..49) {
                if (state()["success"] == true) return
                Thread.sleep(100)
            }
            fail("Canvas did not recover: ${state()}")
        }
        fun seconds(): Double {
            val result = SkiaFunctions.Export(context).execute(mapOf("canvasId" to id, "format" to "png", "width" to 120, "height" to 100))
            assertEquals(result.toString(), true, result["success"])
            File(result["path"] as String).delete()
            return (result["seconds"] as Number).toDouble()
        }
        instrumentation.runOnMainSync {
            parent = activity.findViewById(android.R.id.content)
            view = SkiaView(activity)
            parent.addView(view, android.view.ViewGroup.LayoutParams(360, 300))
            view.configure(json, "", "contain", true, false, id, 0, 0)
        }
        try {
            waitReady()
            Thread.sleep(200)
            instrumentation.runOnMainSync { view.configure(json, "", "contain", false, false, id, 0, 0) }
            instrumentation.waitForIdleSync()
            val paused = seconds()
            Thread.sleep(150)
            assertEquals("Paused native clock remains still", paused, seconds(), 0.000001)
            instrumentation.runOnMainSync { view.configure(json, "", "contain", true, false, id, 0, 0) }
            Thread.sleep(200)
            assertTrue("Native clock resumes", seconds() > paused)
            repeat(6) {
                instrumentation.runOnMainSync { parent.removeView(view) }
                instrumentation.waitForIdleSync()
                assertTrue("Detached canvas rejects commands", state().containsKey("error"))
                instrumentation.runOnMainSync { parent.addView(view, android.view.ViewGroup.LayoutParams(360, 300)) }
                waitReady()
                seconds()
            }
        } finally {
            instrumentation.runOnMainSync { (view.parent as? android.view.ViewGroup)?.removeView(view); view.release() }
        }
        assertTrue("Released canvas is unregistered", state().containsKey("error"))
    }
}
