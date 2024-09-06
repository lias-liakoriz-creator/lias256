<?php

// Function to generate a slug from a string
function slugify($string){
    // Define prepositions and articles to be removed
    $preps = array('in', 'at', 'on', 'by', 'into', 'off', 'onto', 'from', 'to', 'with', 'a', 'an', 'the', 'using', 'for');
    $pattern = '/\b(?:' . join('|', $preps) . ')\b/i';
    
    // Remove prepositions and articles
    $string = preg_replace($pattern, '', $string);
    
    // Replace non-letter or digits with hyphens
    $string = preg_replace('~[^\\pL\d]+~u', '-', $string);
    
    // Trim hyphens from the start and end
    $string = trim($string, '-');
    
    // Transliterate characters to ASCII
    $string = iconv('utf-8', 'us-ascii//TRANSLIT', $string);
    
    // Convert to lowercase
    $string = strtolower($string);
    
    // Remove unwanted characters
    $string = preg_replace('~[^-\w]+~', '', $string);

    return $string;
}

// Example usage with data from your database

// Sample candidate name from the candidates table
$candidate_name = "John Doe"; // This could be fetched from the candidates table
$slug = slugify($candidate_name);
echo "Slug for the candidate: " . $slug;

// Sample position name from the positions table
$position_name = "Secretary General"; // This could be fetched from the positions table
$position_slug = slugify($position_name);
echo "Slug for the position: " . $position_slug;

?>
