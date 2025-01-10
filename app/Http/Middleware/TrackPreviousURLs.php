namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TrackPreviousUrls
{
    public function handle(Request $request, Closure $next)
    {
        // Store the current URL and the previous one
        session()->push('previous_urls', url()->current());

        // Limit the number of stored URLs to the last two
        if (count(session('previous_urls', [])) > 2) {
            session()->forget('previous_urls.0'); // Remove the oldest URL
        }

        return $next($request);
    }
}
