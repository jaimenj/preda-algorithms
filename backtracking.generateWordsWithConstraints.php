<?php

$word = '';
$GLOBALS['totalWords'] = 0;
$letters = 'abcdefghijklmnopqrstuvwxyz';

generateWordsWithConstraints($word, $letters);
echo PHP_EOL.'Found '.$GLOBALS['totalWords'].' words.'.PHP_EOL;

function generateWordsWithConstraints($word, $letters)
{
    //echo 'Current word: '.$word.PHP_EOL;
    if (strlen($word) == 4) {
        echo ' '.$word;
        ++$GLOBALS['totalWords'];
    } else {
        for ($i = 0; $i < strlen($letters); ++$i) {
            $newWord = $word.$letters[$i];
            if (conditions($newWord)) {
                generateWordsWithConstraints($newWord, $letters);
            }
        }
    }
}

function conditions($word)
{
    return condition1($word)
        and condition2($word)
        and condition3($word)
        and condition4($word);
}

// First letter must be vocal.
function condition1($word)
{
    return vowel($word[0]);
}

function vowel($letter)
{
    if ($letter != 'a'
    and $letter != 'e'
    and $letter != 'i'
    and $letter != 'o'
    and $letter != 'u') {
        return false;
    } else {
        return true;
    }
}

// Only two vowels in a row if differents.
function condition2($word)
{
    $ret = true;

    if (strlen($word) >= 2) {
        for ($i = 1; $i < strlen($word); ++$i) {
            if (vowel($word[$i])
            and vowel($word[$i - 1])
            and $word[$i] == $word[$i - 1]) {
                $ret = false;
            }
        }
    }

    return $ret;
}

// No three vowels or consonants in a row.
function condition3($word)
{
    $ret = true;

    if (strlen($word) >= 3) {
        for ($i = 2; $i < strlen($word); ++$i) {
            if (vowel($word[$i])
            and vowel($word[$i - 1])
            and vowel($word[$i - 2])) {
                $ret = false;
            }
            if (!vowel($word[$i])
            and !vowel($word[$i - 1])
            and !vowel($word[$i - 2])) {
                $ret = false;
            }
        }
    }

    return $ret;
}

// Group of pairs of consonants that cannot be in a row.
function condition4($word)
{
    $C = array('bc', 'cd', 'df', 'fg', 'gh', 'hi', 'ij', 'jk', 'kl', 'lm', 'mn', 'no', 'op', 'pq', 'qr', 'rs', 'st', 'tu', 'uv', 'vw', 'wx', 'xy', 'yz');
    $ret = true;

    if (strlen($word) >= 3) {
        for ($i = 1; $i < strlen($word); ++$i) {
            if (in_array($word[$i].$word[$i - 1], $C)) {
                $ret = false;
            }
        }
    }

    return $ret;
}
