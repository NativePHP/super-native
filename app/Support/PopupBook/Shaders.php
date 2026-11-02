<?php

namespace App\Support\PopupBook;

/** SkSL that runs on the GPU every frame; no PHP involved. */
final class Shaders
{
    /** Warm paper with grain and the odd long fiber. */
    public const PAPER = <<<'SKSL'
        uniform float3 paper;
        uniform float seed;
        float hash(float2 p) { return fract(sin(dot(p, float2(12.9898, 78.233)) + seed) * 43758.5453); }
        half4 main(float2 p) {
            float grain = hash(floor(p * 0.75));
            float fiber = hash(floor(float2(p.x * 0.05 + p.y * 0.015, p.y * 0.8)));
            float3 c = paper * (0.972 + 0.028 * grain) - 0.03 * step(0.93, fiber);
            return half4(half3(c), 1.0);
        }
        SKSL;

    /** A night sky that twinkles: a gradient with hashed stars on a grid. */
    public const STARS = <<<'SKSL'
        uniform float time;
        uniform float3 top;
        uniform float3 bottom;
        uniform float height;
        float hash(float2 p) { return fract(sin(dot(p, float2(127.1, 311.7))) * 43758.5453); }
        half4 main(float2 p) {
            float3 c = mix(top, bottom, clamp(p.y / height, 0.0, 1.0));
            float2 cell = floor(p / 26.0);
            float h = hash(cell);
            float2 center = (cell + 0.5 + 0.6 * (float2(hash(cell + 3.1), hash(cell + 7.7)) - 0.5)) * 26.0;
            float d = length(p - center);
            float twinkle = 0.5 + 0.5 * sin(time * (1.2 + 2.5 * h) + h * 50.0);
            c += step(0.78, h) * smoothstep(2.2, 0.0, d) * (0.35 + 0.65 * twinkle);
            return half4(half3(c), 1.0);
        }
        SKSL;

    /** Slow aurora ribbons over a starry sky. */
    public const AURORA = <<<'SKSL'
        uniform float time;
        uniform float2 size;
        float hash(float2 p) { return fract(sin(dot(p, float2(127.1, 311.7))) * 43758.5453); }
        half4 main(float2 p) {
            float2 uv = p / size;
            float3 c = mix(float3(0.05, 0.07, 0.2), float3(0.23, 0.15, 0.38), uv.y);
            for (int i = 0; i < 3; i++) {
                float f = float(i);
                float y = 0.2 + 0.09 * f + 0.05 * sin(uv.x * 5.0 + time * 0.5 + f * 1.9) + 0.025 * sin(uv.x * 13.0 - time * 0.8 + f);
                float band = exp(-pow((uv.y - y) * 16.0, 2.0)) * (0.55 - 0.13 * f);
                c += band * mix(float3(0.25, 0.95, 0.65), float3(0.65, 0.45, 1.0), clamp(uv.x + 0.3 * f, 0.0, 1.0));
            }
            float2 cell = floor(p / 24.0);
            float h = hash(cell);
            float d = length(p - (cell + 0.5) * 24.0);
            c += step(0.8, h) * smoothstep(1.8, 0.0, d) * (0.6 + 0.4 * sin(time * 2.0 + h * 40.0));
            return half4(half3(c), 1.0);
        }
        SKSL;
}
