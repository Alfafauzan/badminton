<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;
use App\Models\Article;

class ActivityLogController extends Controller
{
    public function index()
    {
        $activities = Activity::latest()->paginate(20);
        return view('activity.index', compact('activities'));
    }

    public function restore($id)
    {
        $activity = Activity::findOrFail($id);

        if ($activity->subject_type === Article::class) {
            $oldData = $activity->properties['old'] ?? null;

            if ($oldData) {
                $article = Article::find($activity->subject_id);
                if ($article) {
                    $article->update($oldData);
                    return redirect()->route('activity.index')->with('success', 'Artikel berhasil di-restore.');
                }
            }
        }

        return redirect()->route('activity.index')->with('error', 'Data tidak bisa di-restore.');
    }
}

