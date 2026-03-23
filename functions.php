<?php

/**
 * Calcule le score et les raisons pour un contenu donné
 * @param array $content
 * @return array [ 'score' => int, 'reasons' => array, 'content' => array ]
 */
function calculerScoreEtRaisons(array $content): array
{
    $score   = 0;
    $reasons = [];

    $views = $content['views'] ?? 0;
    if ($views > 200) {
        $score += 3;
        $reasons[] = 'plus de 200 vues';
    } elseif ($views >= 100) {
        $score += 2;
        $reasons[] = 'entre 100 et 200 vues';
    }

    $isFeatured = $content['featured'] ?? false;
    if ($isFeatured === true) {
        $score += 3;
        $reasons[] = 'contenu mis en avant';
    }

    $tags = $content['tags'] ?? [];
    if (in_array('javascript', $tags) || in_array('data', $tags)) {
        $score += 2;
        if (in_array('javascript', $tags) && in_array('data', $tags)) {
            $reasons[] = 'tag javascript et data';
        } elseif (in_array('javascript', $tags)) {
            $reasons[] = 'tag javascript';
        } else {
            $reasons[] = 'tag data';  
        }
    }

    $author = $content['author'] ?? null;
    if ($author !== null && $author !== '') {
        $score += 1;
        $reasons[] = "auteur défini";
    }

    return [
        'score'   => $score,
        'reasons' => $reasons,
        'content' => $content,
    ];
}

/**
 * Compte le nombre de contenus publiés par type
 * @param array $contents
 * @return array
 */
function compterParType(array $contents): array
{
    $counts = [
        'article' => 0,
        'event'   => 0,
        'project' => 0,
    ];

    foreach ($contents as $item) {
        $type = $item['type'] ?? 'other';
        if (array_key_exists($type, $counts)) {
            $counts[$type]++;
        }
    }

    return $counts;
}