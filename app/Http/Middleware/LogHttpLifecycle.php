<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogHttpLifecycle
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 入口: コントローラーに行く前
        \Log::info('=== Request received ===', [
            'method' => $request->method(),   // GET/POST等
            'url' => $request->url(),          // どのURLか
            'input' => $request->all(),        // 送信データ(さっきddで見たやつ)
        ]);

        $response = $next($request);           // ★ここでコントローラーを実行

        // 出口: コントローラーが終わった後
        \Log::info('=== Response sent ===', [
            'status' => $response->status(),   // 返したステータスコード(302等)
        ]);

        return $response;

    }
}
