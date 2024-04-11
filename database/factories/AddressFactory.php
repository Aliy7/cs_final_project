<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $city = [
            'London', 'Edinburgh', 'Birmingham', 'Leeds', 'Glasgow', 'Sheffield', 'Bradford', 
            'Liverpool', 'Manchester', 'Bristol', 'Wakefield', 'Cardiff', 'Coventry', 'Nottingham', 
            'Leicester', 'Sunderland', 'Belfast', 'Newcastle upon Tyne', 'Brighton', 'Hull', 
            'Plymouth', 'Stoke-on-Trent', 'Wolverhampton', 'Derby', 'Swansea', 'Southampton', 
            'Salford', 'Aberdeen', 'Westminster', 'Portsmouth', 'York', 'Peterborough', 'Dundee', 
            'Lancaster', 'Oxford', 'Newport', 'Preston', 'St Albans', 'Norwich', 'Chester', 
            'Cambridge', 'Salisbury', 'Exeter', 'Gloucester', 'Lisburn', 'Chichester', 'Winchester', 
            'Londonderry', 'Carlisle', 'Worcester', 'Bath', 'Durham', 'Lincoln', 'Hereford', 
            'Armagh', 'Inverness', 'Stirling', 'Canterbury', 'Lichfield', 'Newry', 'Ripon', 
            'Bangor', 'Truro', 'Ely', 'Wells', 'St Davids'
        ];        
        $county = [
            // England
            'Greater London', 'West Midlands', 'Greater Manchester', 'West Yorkshire', 'Merseyside', 'South Yorkshire', 
            'Tyne and Wear', 'East Midlands', 'North West', 'North East', 'Yorkshire and the Humber', 
            'South West', 'South East', 'East of England', 'London',
        
            // Scotland
            'City of Edinburgh', 'Glasgow City', 'Aberdeenshire', 'Fife', 'Highland', 'Dumfries and Galloway', 
            'North Lanarkshire', 'South Lanarkshire', 'Aberdeen City', 'Dundee City',
        
            // Wales
            'South Glamorgan', 'Mid Glamorgan', 'West Glamorgan', 'Gwynedd', 'Carmarthenshire', 'Pembrokeshire', 
            'Monmouthshire', 'Flintshire', 'Wrexham', 'Powys',
        
            // Northern Ireland
            'Antrim', 'Down', 'Armagh', 'Derry', 'Tyrone', 'Fermanagh'
        ];
        
        $country = ['Scotland', 'Wales', 'Northern Ireland', 'England'];
        $user = User::inRandomOrder()->first() ?? User::factory()->create();

        return [
            'street' => fake()->word,
            'city' => fake()->randomElement($city),
            'county' =>fake()->randomElement($county),
            'postcode' => fake()->word,
            'country' => fake() -> randomElement($country),
            'user_id' => $user->id,

        ];
    }
}
