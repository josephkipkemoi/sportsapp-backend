<?php

namespace Tests\Feature;

use App\Models\SocialShare;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SocialShareTest extends TestCase
{
    // use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_can_get_social_share_links()
    {
        $response = $this->get('api/social-share?betSession=11');
  
        $response->assertStatus(200);
    }

    public function test_can_post_current_betslip_to_be_shared()
    {
        // $response = $this->post('api/social-share/codes', [
        //     'codes' => [862411, 809912],
        //     'share_code' => 1223341
        // ]);

        // $response->assertCreated();
    }

    public function test_can_get_shared_codes()
    {
        $code = 9650297;
 
        $response = $this->get("api/social-share/codes/show?share_code={$code}");
 
        $response->assertOk();
    }
}
