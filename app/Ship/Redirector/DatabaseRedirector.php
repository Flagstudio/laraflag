<?php

namespace App\Ship\Redirector;

use App\Containers\Settings\Domain\Entities\Redirect;
use Spatie\MissingPageRedirector\Redirector\Redirector;
use Symfony\Component\HttpFoundation\Request;

class DatabaseRedirector implements Redirector
{
    /**
     * @param Request $request
     *
     * @return array
     */
    public function getRedirectsFor(Request $request): array
    {
        $redirects = Redirect::all();

        $redirectsArray = [];

        foreach ($redirects as $redirect) {
            $redirectsArray[$redirect->from] = $redirect->to;
        }

        return $redirectsArray;
    }
}
