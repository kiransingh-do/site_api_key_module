<?php

namespace Drupal\site_api_key\Controller;

use Drupal\node\NodeInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 *
 */
class SiteApiKeyController {

  /**
   * @param $site_api_key
   *   - The API key parameter.
   * @param \Drupal\node\NodeInterface $node
   *   - The node built from the node id parameter.
   * @return \Symfony\Component\HttpFoundation\JsonResponse
   */
  public function content($site_api_key, NodeInterface $node) {
    // Site API Key configuration value.
    $site_api_key_saved = \Drupal::config('siteapikey.configuration')->get('siteapikey');

    // Make sure the supplied node is a page, the configuration key is
    // set and matches the supplied key.
    if ($node->getType() == 'page' && $site_api_key_saved != 'No API Key yet' && $site_api_key_saved == $site_api_key) {
      // Respond with the json representation of the node.
      return new JsonResponse($node->toArray(), 200, ['Content-Type' => 'application/json']);
    }

    // Respond with access denied.
    return new JsonResponse(["error" => "access denied"], 401, ['Content-Type' => 'application/json']);
  }

}
