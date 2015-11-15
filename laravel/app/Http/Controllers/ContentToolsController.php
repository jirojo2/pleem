<?php

namespace App\Http\Controllers;

use Gate;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

/**
 * Convenience Controller to access the event resource without
 * specifiying its parent LC Id
 */
class ContentToolsController extends Controller
{
    /**
     * Save the HTML page
     *
     * @param  Request  $request
     * @return Response
     */
    public function savePage(Request $request)
    {
        // DISABLE UNTIL FURTHER NOTICE
        //abort(403);

        // Authorize
        if (Gate::denies('save-page')) {
            abort(403);
        }

        // Find HTML file
        $filename = $request->input('__page__');
        if (empty($filename)) {
            $filename = 'index.html';
        }
        $filename = str_replace('..', '', $filename);
        $filename = dirname(__FILE__).'/../../../public/templates/'.$filename;

        // Check if file exists
        if (!file_exists($filename)) {
            abort(404);
        }

        // Read the contents of the HTML file and update it
        $html = file_get_contents($filename);

        // For each parameter in the request attempt to match and replace the
        // value in the HTML.
        foreach ($request->all() as $name => $value) {

            if ($name == '__page__') {
                continue;
            }

            // Escape backslashes in the value for regular expression use
            $value = str_replace('\\', '\\\\', $value);

            // Match and replace editable regions
            $start = '<!--\s*editable\s+'.preg_quote($name).'\s*-->';
            $end = '<!--\s*endeditable\s+'.preg_quote($name).'\s*-->';
            $html = preg_replace("/($start\s*)(.*?)(\s*$end)/ms", '$1'.$value.'$3', $html);
        }

        // Save changes to the HTML file
        file_put_contents($filename, $html);

        return "saved";
    }
}
