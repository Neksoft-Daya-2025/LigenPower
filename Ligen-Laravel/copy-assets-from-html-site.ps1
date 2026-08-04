# Run this from Ligen-Laravel folder after Laravel is installed.
# Copies assets, uploads, and config from the parent HTML site folder (same folder that contains Ligen-Laravel).

$dest = $PSScriptRoot
$source = Split-Path $dest -Parent   # e.g. LIgen AMossys (the HTML site root)

if (-not (Test-Path $source)) {
    Write-Host "Source not found: $source"
    Write-Host "Edit this script to set the path to your LIgen AMossys folder."
    exit 1
}

Write-Host "Copying from: $source"
Write-Host "To: $dest"

if (Test-Path (Join-Path $source "assets")) {
    Copy-Item -Path (Join-Path $source "assets") -Destination (Join-Path $dest "public\assets") -Recurse -Force
    Write-Host "Copied assets/ -> public/assets/"
}
if (Test-Path (Join-Path $source "uploads")) {
    Copy-Item -Path (Join-Path $source "uploads") -Destination (Join-Path $dest "public\uploads") -Recurse -Force
    Write-Host "Copied uploads/ -> public/uploads/"
}
if (Test-Path (Join-Path $source "config\posts.json")) {
    New-Item -ItemType Directory -Path (Join-Path $dest "storage\app") -Force | Out-Null
    Copy-Item -Path (Join-Path $source "config\posts.json") -Destination (Join-Path $dest "storage\app\posts.json") -Force
    Write-Host "Copied config/posts.json -> storage/app/posts.json"
}
if (Test-Path (Join-Path $source "config\announcement.json")) {
    Copy-Item -Path (Join-Path $source "config\announcement.json") -Destination (Join-Path $dest "storage\app\announcement.json") -Force
    Write-Host "Copied config/announcement.json -> storage/app/announcement.json"
}

Write-Host "Done."
