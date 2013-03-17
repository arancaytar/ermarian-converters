<?php

/**
 * @file markov.php
 * Markov text generator by Arancaytar <arancaytar@ermarian.net>, 2008-2010
 *
 * This file contains two Markov generators; one that is based on whole words
 * and one on scrambling individual letters.
 *
 * To use the word functions:
 * @code
 *   $analysis = w_build_relations($input, $coherence);
 *   $output = w_generate_text($analysis, $length);
 * @endcode
 * (Where "length" is the number of output words, and "coherence"
 *  is the length of the chain - at least 1, usually 2, but optionally more than that.)
 *
 * To use the letter functions:
 * @code
 *   $analysis = l_build_relations($input, $coherence);
 *   $output = l_generate_text($analysis, $length);
 * @endcode
 * (The same applies, except the length and coherence is measured in characters,
 *  not words.)
 */

/**
 * Process a text and build a list of all letter sequences.
 * @param $text
 *   The input text to process.
 * @param $coherence
 *   How many letters to use as function input.
 * @return
 *   A table array of [input][output] -> number
 */
function l_build_relations($text, $coherence) {
  $relations = array();
  for ($i = 0; $i < strlen($text) - $coherence; $i++) {
    $here  = substr($text, $i, $coherence);
    $next  = $text[$i+$coherence];
    if (!isset($relations[$here])) $relations[$here] = array();
    if (!isset($relations[$here][$next])) $relations[$here][$next] = 0;
    $relations[$here][$next]++;
  }
  return $relations;
}

/**
 * Generate a text from the probability profile.
 * @param $profile
 *   The probabilities.
 * @param $length
 *   How many letters to generate.
 * @param $seed
 *   The letter or letter group to start with. If none is given, one will be picked at random.
 */
function l_generate_text($profile, $length, $seed = '') {
  $coherence = strlen(current(array_keys($profile)));
  if (!$seed) $seed = array_rand($profile);
  $text = $seed;

  while (strlen($text) < $length) {
    $last = substr($text, -$coherence);
    if (isset($profile[$last])) $text .= skewed_random($profile[$last]);
    // If the chain breaks, start with a new random piece.
    else $text .= array_rand($profile);
  }
  return $text;
}

/**
 * Process a text and build a list of all word chains.
 * @param $text
 *   The input text to process.
 * @param $coherence
 *   How many words to use as input for the function.
 */
function w_build_relations($text, $coherence) {
  $text = explode(' ', $text);
  $relations = array();
  
  for ($i = 0; $i < count($text) - $coherence; $i++) {
    $here = implode(' ', array_slice($text, $i, $coherence));
    $next = $text[$i + $coherence];
    if (!isset($relations[$here])) $relations[$here] = array();
    if (!isset($relations[$here][$next])) $relations[$here][$next] = 0;
    $relations[$here][$next]++;
  }
  return $relations;
}

/**
 * Generate a text from the word probability profile.
 * @param $profile
 *   The probabilities.
 * @param $length
 *   How many words to generate.
 * @param $seed
 *   The initial word or word group to start with. If none is given, 
 *   one will be picked from the profile at random.
 *   This is an 
 */
function w_generate_text($profile, $length, $seed = '') {
  $coherence = count(explode(' ', (current(array_keys($profile)))));
  if (!$seed) $seed = array_rand($profile);
  $text = explode(' ', $seed);
  while (count($text) < $length) {
    $last = implode(' ', array_slice($text, -$coherence));
    if (!isset($profile[$last])) break; // end of chain error.
    $text[] = skewed_random($profile[$last]);
  }
  return implode(' ', $text);
}

/**
 * Select one of several events with different proportional likelihoods.
 *  PHP has no RNG that selects one of a set of events based on likelihood.
 * To simulate this, each event gets a proportionate segment of a number range.
 * A random number is then selected in this range.
 * @param $probabilities
 *   An array that maps each event to a weight. The weights will be scaled down
 *   to make the sum equal to 1.
 * @return
 *   One of the event keys in the array.
 */
function skewed_random($probabilities) {
  $sum = 0;
  $cumulative = array();
  foreach ($probabilities as $event => $p) {
    $sum += $p;
    $cumulative[$event] = $sum;
  }

  $rand = mt_rand(0, $sum);
  foreach ($cumulative as $event => $p) {
    if ($rand <= $p) return $event;
  }
}

