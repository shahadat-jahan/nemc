<?php

namespace App\Http\Middleware;

use App\Models\Storage;
use Closure;
use Illuminate\Support\Facades\Auth;

/**
 * Class CheckAuthorizedOwner
 * @package App\Http\Middleware
 */
class CheckAuthorizedOwner
{

    /**
     * @var Storage
     */
    private $storage;

    /**
     * CheckAuthorizedOwner constructor.
     * @param Storage $storage
     */
    public function __construct(Storage $storage)
    {
        $this->storage = $storage;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::user()->user_group_id == 2 ){ // only for storage owner
            $userId = Auth::user()->id;

            $storageId = $request->segment(3);
            $storage = $this->storage->find($storageId);

            if ($storage->user_id != $userId){
                return redirect('admin/storages')->with('message', setMessage('error', 'You are not authorized to access this storage'));
            }
        }

        return $next($request);
    }
}
