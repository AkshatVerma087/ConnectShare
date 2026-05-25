<?php

/**
 * Vercel serverless entrypoint for Laravel.
 *
 * This file is invoked by @vercel/php for every request.
 * It sets the working directory to the project root so that
 * Laravel can locate config, routes, views, and vendor.
 */

// Vercel runs this file from the api/ directory — switch to project root.
chdir(__DIR__ . '/..');

require __DIR__ . '/../public/index.php';