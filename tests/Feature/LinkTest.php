<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Testing\Assert;
use Tests\TestCase;

class LinkTest extends TestCase
{
    // Clear tables of db before and after each test
    // Each test run in a db transaction
    use RefreshDatabase;

    /**
     * Add a uniq url in DB.
     *
     * @return void
     */
    public function test_store_one_url()
    {
        // Add a new URL to shortcut
        $response = $this
            ->from(route("link.index"))
            ->post(route("link.store"), ['url' => 'https://google.com']);

        // Check the "info" message
        $expectedInfo = "Nouveau raccourci";
        $infoMessage = $response->getSession()->all()["info"];
        Assert::assertStringStartsWith($expectedInfo, $infoMessage);

        // Check if the response is a redirection
        $response->assertStatus(302);
        $response->assertRedirect(route("link.index"));

        // Follow the redirection
        $response = $this->get($response->headers->get('Location'));

        // Check if the response succeed
        $response->assertStatus(200);

        // Check if the generated page contains the correct info message
        Assert::assertStringContainsString($infoMessage, $response->getContent());
    }

    /**
     * Store without url in DB.
     *
     * @return void
     */
    public function test_store_empty_url()
    {
        // Add a new URL to shortcut
        $response = $this
            ->from(route("link.index"))
            ->post(route("link.store"));

        // Check the "error" message
        $expectedError = "Le champ \"url\" est obligatoire.";
        $errorMessage = $response->getSession()->all()["error"];
        Assert::stringContains($expectedError, $errorMessage);

        // Check if the response is a redirection
        $response->assertStatus(302);
        $response->assertRedirect(route("link.index"));

        // Follow the redirection
        $response = $this->get($response->headers->get('Location'));

        // Check if the response succeed
        $response->assertStatus(200);

        // Check if the generated page contains the correct info message
        Assert::assertStringContainsString(htmlentities($errorMessage), $response->getContent());
    }

    /**
     * Store an url with wrong format in DB.
     *
     * @return void
     */
    public function test_store_wrong_format_url()
    {
        // Add a new URL to shortcut
        $response = $this
            ->from(route("link.index"))
            ->post(route("link.store"), ['url' => 'http:/google.fr']);

        // Check the "error" message
        $expectedError = "Le champ \"url\" doit être une URL valide.";
        $errorMessage = $response->getSession()->all()["error"];
        Assert::stringContains($expectedError, $errorMessage);

        // Check if the response is a redirection
        $response->assertStatus(302);
        $response->assertRedirect(route("link.index"));

        // Follow the redirection
        $response = $this->get($response->headers->get('Location'));

        // Check if the response succeed
        $response->assertStatus(200);

        // Check if the generated page contains the correct info message
        Assert::assertStringContainsString(htmlentities("Le champ \"url\" doit ") . "être une URL valide.", $response->getContent());
    }

    /**
     * Add an inactive url in DB.
     *
     * @return void
     */
    public function test_store_inactive_url()
    {
        // Add a new URL to shortcut
        $response = $this
            ->from(route("link.index"))
            ->post(route("link.store"), ['url' => 'https://aagle.com']);

        // Check the "error" message
        $expectedError = "Le champ \"url\" ne contient pas une URL active.";
        $errorMessage = $response->getSession()->all()["error"];
        Assert::stringContains($expectedError, $errorMessage);

        // Check if the response is a redirection
        $response->assertStatus(302);
        $response->assertRedirect(route("link.index"));

        // Follow the redirection
        $response = $this->get($response->headers->get('Location'));

        // Check if the response succeed
        $response->assertStatus(200);

        // Check if the generated page contains the correct info message
        Assert::assertStringContainsString(htmlentities($errorMessage), $response->getContent());
    }
}
