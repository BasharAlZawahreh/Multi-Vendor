<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Request;

class InvalidOrderException extends Exception
{
    public function report(Request $request) //reports an error to the log file
    {
    }

    public function render(Request $request)
    {
        redirect()->route('home.index')->withInput()->withErrors([
            'message' => $this->getMessage()
        ])->with('info', $this->getMessage());

    }
}
