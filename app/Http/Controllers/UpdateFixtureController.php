<?php

namespace App\Http\Controllers;

use App\Models\CustomFixture;
use Illuminate\Http\Request;

class UpdateFixtureController extends Controller
{
    //
    public function update(AdminController $admin, CustomFixture $fixture, CustomFixtureController $fixtureController)
    {
        $removeFixtures = $admin->fixture_ids($fixture);
         
        if($removeFixtures->getStatusCode() == 200) {

           $fixtureStatus = $fixtureController->post_fixture($fixture);

            return $fixtureStatus;
        }
    }

    public function update_odds(AdminController $admin, CustomFixture $fixture, CustomFixtureController $fixtureController)
    {
        $response = $this->update($admin, $fixture, $fixtureController);

        if($response->getStatusCode() == 200) {
            $oddsStatus = $fixtureController->post_odds($fixture);
            return $oddsStatus;
        };
    }
}
