<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Land; // Make sure to use your actual model

class CheckPlotPermission
{
    public function handle(Request $request, Closure $next): Response
    {
        // Attempt to retrieve a Land model directly from the route.
        $land = $request->route('land') ?? $request->route('id');

        if($land) {
            // If the route parameter is an ID (numeric), find the Land model.
            if (is_numeric($land)) {
                $land = Land::find($land);
            }

            // If no Land model is found, abort with a 404 status.
            if (!$land) {
                return abort(404, 'Land not found.');
            }

            // Perform the permission check.
            // You need to adjust this logic to fit your application.
            // This example assumes you're checking a permission related to the Land model.
            if (!Auth::user()->hasrole('super-admin') && (!Auth::user()->can('lands-edit') || !Auth::user()->can($land->slug))) { // Adjust the 'view' permission as needed
                // If the user does not have the required permission, abort with a 403 status.
                return abort(403, 'USER DOES NOT HAVE ANY OF THE NECESSARY ACCESS RIGHTS.');
            }
        }

        // If permission check passes, proceed with the request.
        return $next($request);
    }
}
