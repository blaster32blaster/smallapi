<?php

namespace App\Http\Middleware;

use App\Models\File;
use App\Models\Tag;
use App\Models\User;
use Closure;
use Exception;
use Illuminate\Http\Request;

class VerifyJwt
{
    /**
     * the user
     *
     * @var User $user
     */
    private $user;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $bearer = $request->bearerToken();

        if (!$bearer) {
            return response('Unauthorized', 401);
        }
        $this->user = auth()->user();

        if (!$this->user) {
            return response('Unauthorized', 401);
        }

        $method = $request->method();
        $requestroute = $request->route();

        if (str_contains($requestroute->uri, 'users')) {
            return $next($request);
        }

        if ($method === 'POST') {
            return $next($request);
        }

        try {
            $modelUser = $this->resolveModelUser($request, $requestroute);

            if ($this->user->id !== $modelUser->id) {
                return response('Unauthorized', 403);
            }
        } catch (Exception $e) {
            logger()->error('error fetching user', [
                'user_middleware_error' => $e->getMessage(),
                'stack' => $e->getTraceAsString()
            ]);
            return response('Unauthorized', 403);
        }

        return $next($request);
    }

    /**
     * handle fetching user model
     *
     * @param mixed $request
     * @param mixed $route
     * @return void
     */
    private function resolveModelUser($request, $route) : ?User
    {
        if (str_contains($route->uri, 'tags')) {
            logger()->error('tags');
            $tag = $request->tag;
            $user = User::whereHas('posts.tags', function ($tags) use ($tag) {
                $tags->where('tags.id', '=', $tag->id);
            })
            ->where('users.id', '=', $this->user->id)
            ->first();

            if (!$user) {
                throw new Exception('no user found');
            }
            return $user;
        }

        if (str_contains($route->uri, 'posts')) {
            $post = $request->post;
            return $post->user;
        }

        if (str_contains($route->uri, 'files')) {
            $file = $request->file;
            return $file->post->user;
        }
    }
}
