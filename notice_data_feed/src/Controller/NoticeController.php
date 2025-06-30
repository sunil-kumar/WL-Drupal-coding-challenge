<?php

/**
 * Default controller for the notice_data_feed
 * module.
 */

namespace Drupal\notice_data_feed\Controller;

use Drupal\Core\Url;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\user\Entity\User;
use Symfony\Component\HttpFoundation\Response;
use GuzzleHttp\Exception\RequestException;

class NoticeController extends ControllerBase {

  public function feed() {

        $output = [];

    try {
    // Make a GET request to the thegazette notice API.
    $response = \Drupal::httpClient()->get('https://www.thegazette.co.uk/all-notices/notice/data.json', [
      'verify' => false,
    ]);

    // Decode the JSON response.
    $data = json_decode($response->getBody(), TRUE);

    \Drupal::logger('gazette_api')->info('<pre><code><pre>@data</pre></code></pre>', [
      '@data' => print_r($data, TRUE),
    ]);

      // Check if data exists and loop through.
      if (!empty($data['entry'])) {
        foreach ($data['entry'] as $notice) {
          $title = $notice['title'] ?? 'No title';
          $url = $notice['id'] ?? '#';
          $publish_date = !empty($notice['published']) ? date('j F Y', strtotime($notice['published'])) : 'N/A';
          $content = $notice['content'] ?? 'No description';

          $output[] = [
            '#markup' => "<b><a href='$url' target='_blank'>$title</a></b>
                          <h6><strong>Published on:</strong> $publish_date</h6>
                          <p>$content</p><hr>",
          ];
        }
      }
      else {
        $output[] = ['#markup' => '<p>No notices found.</p>'];
      }

    } catch (RequestException $e) {
      \Drupal::logger('gazette_notice')->error($e->getMessage());
      $output[] = ['#markup' => '<p><strong>Error fetching data.</strong></p>'];
    }

    return $output;

  }
}
