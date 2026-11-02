#!/bin/sh
# Run after native:run has installed a current debug app on the selected device.
set -eu
TASK_ROOT=$(CDPATH= cd -- "$(dirname -- "$0")" && pwd)
TASK_APP=$(CDPATH= cd -- "$TASK_ROOT/../.." && pwd)
TASK_SERIAL=${1:?Pass an adb serial}
TASK_FONT=${2:?Pass a redistributable TTF font fixture}
TASK_PHP=${SKIA_TEST_PHP:-php}
TASK_ADB=${ANDROID_HOME:?Set ANDROID_HOME}/platform-tools/adb
TASK_PACKAGE=${SKIA_TEST_APP_ID:-com.nativephp.kitchensink}
TASK_BUILD="$TASK_APP/nativephp/android"
TASK_TEST="$TASK_BUILD/app/src/androidTest"
mkdir -p "$TASK_TEST/java/com/nativephp/plugins/skia" "$TASK_TEST/assets/skia"
cp "$TASK_ROOT/SkiaIntegrationTest.kt" "$TASK_TEST/java/com/nativephp/plugins/skia/SkiaIntegrationTest.kt"
"$TASK_PHP" "$TASK_ROOT/export-scenes.php" "$TASK_TEST/assets/skia"
cp "$TASK_FONT" "$TASK_TEST/assets/skia/font.ttf"
(cd "$TASK_BUILD" && ./gradlew :app:assembleDebug :app:assembleDebugAndroidTest --console=plain)
"$TASK_ADB" -s "$TASK_SERIAL" install -r "$TASK_BUILD/app/build/outputs/apk/debug/app-debug.apk"
"$TASK_ADB" -s "$TASK_SERIAL" install -r "$TASK_BUILD/app/build/outputs/apk/androidTest/debug/app-debug-androidTest.apk"
TASK_RESULT=$(mktemp)
trap 'rm -f "$TASK_RESULT"' EXIT HUP INT TERM
"$TASK_ADB" -s "$TASK_SERIAL" shell am instrument -w -e class com.nativephp.plugins.skia.SkiaIntegrationTest "$TASK_PACKAGE.test/androidx.test.runner.AndroidJUnitRunner" > "$TASK_RESULT"
cat "$TASK_RESULT"
# am instrument can exit zero even when JUnit fails or the process crashes.
"$TASK_PHP" -r '$text = file_get_contents($argv[1]); exit(preg_match("/OK \(\d+ tests?\)/", $text) && !preg_match("/FAILURES|INSTRUMENTATION_FAILED|Process crashed/", $text) ? 0 : 1);' "$TASK_RESULT"
