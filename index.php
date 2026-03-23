<?php
require_once 'data.php';
require_once 'functions.php';

$publishedContents = [];
$ignoredContents   = [];

foreach ($contents as $item) {
    $status = $item['status'] ?? 'draft'; 
    if ($status === 'published') {
        $publishedContents[] = $item;
    } else {
        $ignoredContents[] = $item;
    }
}

$counts = compterParType($publishedContents);

echo "\n\t Summary \n\n";
echo "Articles : " . $counts['article'] . "\n";
echo "Events : " . $counts['event'] . "\n";
echo "Projects : " . $counts['project'] . "\n";
echo "\n";

$scoredContents = [];

foreach ($publishedContents as $item) {
    $scoredContents[] = calculerScoreEtRaisons($item);
}

usort($scoredContents, function ($a, $b) {
    return $b['score'] <=> $a['score'];
});

$featuredContents = [];
$otherContents    = [];

foreach ($scoredContents as $item) {
    if ($item['score'] >= 5) {
        $featuredContents[] = $item;
    } else {
        $otherContents[] = $item;
    }
}

echo "\t Featured contents \n\n";

if (empty($featuredContents)) {
    echo "(no featured content)\n";
} else {
    $rank = 1;
    foreach ($featuredContents as $item) {
        $title = $item['content']['title'];
        $score = $item['score'];
        echo "$rank. $title (score: $score)\n";
        $rank++;
    }
}

echo "\n\t Other contents \n\n";

if (empty($otherContents)) {
    echo "(no other content)\n";
} else {
    $rank = 1;
    foreach ($otherContents as $item) {
        $title = $item['content']['title'];
        $score = $item['score'];
        echo "$rank. $title (score: $score)\n";
        $rank++;
    }
}

echo "\n";

echo "\t Score explanation\n\n";

foreach ($scoredContents as $item) {
    $title   = $item['content']['title'];
    $score   = $item['score'];
    $reasons = $item['reasons'];

    echo "$title\n";
    echo "score : $score\n";

    if (empty($reasons)) {
        echo "  - Aucune raison particulière\n";
    } else {
        echo "reasons :\n";
        foreach ($reasons as $reason) {
            echo "  - $reason\n";
        }
    }
    echo "\n";
}

echo "=== End ===\n";