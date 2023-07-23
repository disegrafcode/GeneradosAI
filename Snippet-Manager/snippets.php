<?php
// JSON file path
$filePath = 'snippets.json';

// Function to read the JSON file and return the contents
function readSnippets() {
  global $filePath;
  $json = file_get_contents($filePath);
  return $json ? json_decode($json, true) : [];
}

// Function to save the snippets to the JSON file
function saveSnippets($snippets) {
  global $filePath;
  $json = json_encode($snippets, JSON_PRETTY_PRINT);
  file_put_contents($filePath, $json);
}

// Retrieve snippets
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
  $snippets = readSnippets();
  header('Content-Type: application/json');
  echo json_encode($snippets);
}

// Create a new snippet
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $data = json_decode(file_get_contents('php://input'), true);
  if ($data) {
    $snippets = readSnippets();
    $newSnippet = [
      'id' => uniqid(),
      'title' => $data['title'],
      'code' => $data['code']
    ];
    $snippets[] = $newSnippet;
    saveSnippets($snippets);
  }
}

// Update a snippet
if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
  $data = json_decode(file_get_contents('php://input'), true);
  if ($data) {
    $snippets = readSnippets();
    $snippetIndex = array_search($data['id'], array_column($snippets, 'id'));
    if ($snippetIndex !== false) {
      $snippets[$snippetIndex]['title'] = $data['title'];
      $snippets[$snippetIndex]['code'] = $data['code'];
      saveSnippets($snippets);
    }
  }
}

// Delete a snippet
if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
  if (isset($_GET['id'])) {
    $snippets = readSnippets();
    $snippetIndex = array_search($_GET['id'], array_column($snippets, 'id'));
    if ($snippetIndex !== false) {
      array_splice($snippets, $snippetIndex, 1);
      saveSnippets($snippets);
    }
  }
}
