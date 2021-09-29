<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class RenameUploadedFiles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $fileBag = $request->files;
        foreach ($request->files as $key => $input) {
            if (is_a($input, UploadedFile::class)) {
                $fileBag->set($key, $this->rename($input));
            } else {
                foreach ($input as &$files) {
                    foreach ($files as $counter => $file) {
                        $files[$counter] = $this->rename($file);
                    }
                }
                $fileBag->set($key, $input);
            }
        }

        return $next($request);
    }

    /**
     * @param UploadedFile $file
     *
     * @return UploadedFile
     */
    protected function rename(UploadedFile $file)
    {
        $fileParts = (object)pathinfo('.' . $file->getClientOriginalName());
        $newFileName = Str::slug($fileParts->filename) . '.' . $file->getClientOriginalExtension();

        return new UploadedFile($file->getPathname(), $newFileName);
    }
}
