<?php

namespace Thaumatic;

class IndefiniteArticle
{

    public static function a($text)
    {
        $matches = [];
        $matchCount = preg_match('/\A(\s*)(?:an?\s+)?(.+?)(\s*)\Z/i', $text, $matches);
        if (count($matches) < 4) {
            return $text;
        }
        list($all, $pre, $word, $post) = $matches;
        if (!$word) {
            return $text;
        }
        $form = self::indefiniteArticleForm($word);
        return sprintf('%s%s %s%s', $pre, $form, $word, $post);
    }

    private static function indefiniteArticleForm($word)
    {
        // Handle numbers in digit form.  These need to be checked early due
        // to the methods used in some cases below.
        //
        // Any number starting with an '8' uses 'an'.
        if (preg_match('/^8(?:\d+)?/', $word)) {
            return 'an';
        }
        // Numbers starting with a '1' are trickier, only use 'an'
        // if there are 3, 6, 9, ... digits after the 11 or 18
        //
        // Check if word starts with 11 or 18.
        if (preg_match('/^11(?:\d+)?/', $word) || preg_match('/^18(?:\d+)?/', $word)) {
            // First strip off any decimals and remove spaces or commas.
            // Then if the number of digits modulo 3 is 1 we have a match.
            if (strlen(preg_replace(['/\s/', '/,/', '/\.(\d+)?/'], '', $word)) % 3 == 1) {
                return 'an';
            }
        }
        // Handle ordinal forms.
        if (preg_match('/^(?:[bcdgjkpqtuvwyz]-?th)/i', $word)) {
            return 'a';
        }
        if (preg_match('/^(?:[aefhilmnorsx]-?th)/i', $word)) {
            return 'an';
        }
        // Handle special cases.
        if (preg_match('/^(?:euler|hour(?!i)|heir|honest|hono)/i', $word)) {
            return 'an';
        }
        if (preg_match('/^[aefhilmnorsx]$/i', $word)) {
            return 'an';
        }
        if (preg_match('/^[bcdgjkpqtuvwyz]$/i', $word)) {
            return 'a';
        }
        // Handle abbreviations.
        if (preg_match(
            // This pattern matches strings of capitals starting with a
            // "vowel-sound" consonant followed by another consonant, and
            // which are not likely to be real words.
            '/^(?:
                (?!
                    FJO
                    | [HLMNS]Y.
                    | RY[EO]
                    | SQU
                    | ( F[LR]? | [HL] | MN? | N | RH? | S[CHKLMNPTVW]? | X(YL)? ) [AEIOU]
                )
                [FHLMNRSX][A-Z]
            )/x',
            $word
        )) {
            return 'an';
        }
        if (preg_match('/^[aefhilmnorsx][.-]/i', $word)) {
            return 'an';
        }
        if (preg_match('/^[a-z][.-]/i', $word)) {
            return 'a';
        }
        // Handle consonants.  The way this is written it will match any digit,
        // as well as non-vowels; this is necessary for later matching of some
        // special cases.  Digit recognition needs to be above this.  The rule
        // is: case-insensitively match any string that starts with a letter
        // not in [aeiouy].
        if (preg_match('/^[^aeiouy]/i', $word)) {
            return 'a';
        }
        // Handle special vowel-forms.
        if (preg_match('/^e[uw]/i', $word)) {
            return 'a';
        }
        if (preg_match('/^onc?e\b/i', $word)) {
            return 'a';
        }
        if (preg_match('/^uni([^nmd]|mo)/i', $word)) {
            return 'a';
        }
        if (preg_match('/^ut[th]/i', $word)) {
            return 'an';
        }
        if (preg_match('/^u[bcfhjkqrst][aeiou]/i', $word)) {
            return 'a';
        }
        // Handle special capitals.
        if (preg_match('/^U[NK][AIEO]?/', $word)) {
            return 'a';
        }
        // Handle vowels.
        if (preg_match('/^[aeiou]/i', $word)) {
            return 'an';
        }
        // Handle y; the pattern encodes the beginnings of all English words
        // beginning with 'y' followed by a consonant, so any other prefix
        // implies an abbreviation.
        if (preg_match('/^(?:y(?:b[lor]|cl[ea]|fere|gg|p[ios]|rou|tt))/i', $word)) {
            return 'an';
        }
        // Otherwise, guess "a".
        return 'a';
    }

}
