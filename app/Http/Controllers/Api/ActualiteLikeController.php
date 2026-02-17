<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Actualite;
use App\Models\ActualiteLike;
use Illuminate\Http\Request;

class ActualiteLikeController extends Controller
{
    /**
     * Ajouter/Retirer un like/réaction
     */
    public function toggle(Request $request, Actualite $actualite)
    {
        $validated = $request->validate([
            'user_identifier' => 'required|string',
            'reaction_type' => 'required|in:like,love,wow,sad,angry',
        ]);

        // Rechercher un like existant
        $existingLike = ActualiteLike::where('actualite_id', $actualite->id)
                                     ->where('user_identifier', $validated['user_identifier'])
                                     ->first();

        if ($existingLike) {
            // Si le même type de réaction, supprimer le like
            if ($existingLike->reaction_type === $validated['reaction_type']) {
                $existingLike->delete();
                $actualite->decrement('likes_count');

                return response()->json([
                    'success' => true,
                    'liked' => false,
                    'reaction_type' => null,
                    'likes_count' => $actualite->fresh()->likes_count,
                ]);
            } else {
                // Si réaction différente, mettre à jour
                $existingLike->update(['reaction_type' => $validated['reaction_type']]);

                return response()->json([
                    'success' => true,
                    'liked' => true,
                    'reaction_type' => $validated['reaction_type'],
                    'likes_count' => $actualite->fresh()->likes_count,
                ]);
            }
        }

        // Créer un nouveau like
        ActualiteLike::create([
            'actualite_id' => $actualite->id,
            'user_identifier' => $validated['user_identifier'],
            'reaction_type' => $validated['reaction_type'],
        ]);

        $actualite->increment('likes_count');

        return response()->json([
            'success' => true,
            'liked' => true,
            'reaction_type' => $validated['reaction_type'],
            'likes_count' => $actualite->fresh()->likes_count,
        ]);
    }

    /**
     * Obtenir les stats de likes
     */
    public function stats(Actualite $actualite)
    {
        $stats = [
            'total' => $actualite->likes_count,
            'by_type' => [
                'like' => $actualite->likesByType('like'),
                'love' => $actualite->likesByType('love'),
                'wow' => $actualite->likesByType('wow'),
                'sad' => $actualite->likesByType('sad'),
                'angry' => $actualite->likesByType('angry'),
            ]
        ];

        return response()->json($stats);
    }

    /**
     * Obtenir la réaction de l'utilisateur
     */
    public function userReaction(Request $request, Actualite $actualite)
    {
        $userIdentifier = $request->query('user_identifier');

        if (!$userIdentifier) {
            return response()->json(['reaction_type' => null]);
        }

        $reaction = $actualite->getUserReaction($userIdentifier);

        return response()->json([
            'reaction_type' => $reaction ? $reaction->reaction_type : null,
        ]);
    }
}
