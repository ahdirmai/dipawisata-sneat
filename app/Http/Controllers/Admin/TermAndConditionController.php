<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TermAndConditionCredits;
use Illuminate\Http\Request;

class TermAndConditionController extends Controller
{
    // Route::get('/', [TermAndConditionController::class, 'index'])->name('index');
    //             Route::post('/store', [TermAndConditionController::class, 'store'])->name('store');

    public function index()
    {
        return view('admin.term-and-condition.index', [
            'termAndCondition' => TermAndConditionCredits::first()
        ]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required'
        ]);

        $termAndCondition = TermAndConditionCredits::first();
        if ($termAndCondition) {
            $termAndCondition->update([
                'content' => $request->content
            ]);
        } else {
            TermAndConditionCredits::create([
                'content' => $request->content
            ]);
        }

        return redirect()->back()->with('success', 'Term and Condition updated successfully');
    }
}
