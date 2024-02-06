<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\State;

class StatesTableSeeder extends Seeder
{
    public $states = [
        [
            "abbr" => "AK",
            "name" => "Alaska",
            "fips" => "02",
            "lon" => -152.24098,
            "lat" => 64.24019,
        ],
        [
            "abbr" => "AL",
            "name" => "Alabama",
            "fips" => "01",
            "lon" => -86.82676,
            "lat" => 32.79354,
        ],
        [
            "abbr" => "AR",
            "name" => "Arkansas",
            "fips" => "05",
            "lon" => -92.4392,
            "lat" => 34.89977,
        ],
        [
            "abbr" => "AS",
            "name" => "American Samoa",
            "fips" => "60",
            "lon" => -170.37215,
            "lat" => -14.26486,
        ],
        [
            "abbr" => "AZ",
            "name" => "Arizona",
            "fips" => "04",
            "lon" => -111.66457,
            "lat" => 34.29323,
        ],
        [
            "abbr" => "CA",
            "name" => "California",
            "fips" => "06",
            "lon" => -119.60818,
            "lat" => 37.24537,
        ],
        [
            "abbr" => "CO",
            "name" => "Colorado",
            "fips" => "08",
            "lon" => -105.54783,
            "lat" => 38.99855,
        ],
        [
            "abbr" => "CT",
            "name" => "Connecticut",
            "fips" => "09",
            "lon" => -72.72623,
            "lat" => 41.62196,
        ],
        [
            "abbr" => "DC",
            "name" => "District of Columbia",
            "fips" => "11",
            "lon" => -77.01464,
            "lat" => 38.90932,
        ],
        [
            "abbr" => "DE",
            "name" => "Delaware",
            "fips" => "10",
            "lon" => -75.50592,
            "lat" => 38.99559,
        ],
        [
            "abbr" => "FL",
            "name" => "Florida",
            "fips" => "12",
            "lon" => -82.50934,
            "lat" => 28.67402,
        ],
        [
            "abbr" => "GA",
            "name" => "Georgia",
            "fips" => "13",
            "lon" => -83.44848,
            "lat" => 32.65155,
        ],
        [
            "abbr" => "GU",
            "name" => "Guam",
            "fips" => "66",
            "lon" => 145.15796,
            "lat" => 14.57384,
        ],
        [
            "abbr" => "HI",
            "name" => "Hawaii",
            "fips" => "15",
            "lon" => -156.34743,
            "lat" => 20.24923,
        ],
        [
            "abbr" => "IA",
            "name" => "Iowa",
            "fips" => "19",
            "lon" => -93.50003,
            "lat" => 42.07463,
        ],
        [
            "abbr" => "ID",
            "name" => "Idaho",
            "fips" => "16",
            "lon" => -114.65933,
            "lat" => 44.38907,
        ],
        [
            "abbr" => "IL",
            "name" => "Illinois",
            "fips" => "17",
            "lon" => -89.19838,
            "lat" => 40.06501,
        ],
        [
            "abbr" => "IN",
            "name" => "Indiana",
            "fips" => "18",
            "lon" => -86.27548,
            "lat" => 39.90801,
        ],
        [
            "abbr" => "KS",
            "name" => "Kansas",
            "fips" => "20",
            "lon" => -98.38019,
            "lat" => 38.48471,
        ],
        [
            "abbr" => "KY",
            "name" => "Kentucky",
            "fips" => "21",
            "lon" => -85.29046,
            "lat" => 37.52668,
        ],
        [
            "abbr" => "LA",
            "name" => "Louisiana",
            "fips" => "22",
            "lon" => -92.02905,
            "lat" => 31.0891,
        ],
        [
            "abbr" => "MA",
            "name" => "Massachusetts",
            "fips" => "25",
            "lon" => -71.81423,
            "lat" => 42.25788,
        ],
        [
            "abbr" => "MD",
            "name" => "Maryland",
            "fips" => "24",
            "lon" => -76.78588,
            "lat" => 39.04533,
        ],
        [
            "abbr" => "ME",
            "name" => "Maine",
            "fips" => "23",
            "lon" => -69.22999,
            "lat" => 45.38046,
        ],
        [
            "abbr" => "MI",
            "name" => "Michigan",
            "fips" => "26",
            "lon" => -85.43675,
            "lat" => 44.34717,
        ],
        [
            "abbr" => "MN",
            "name" => "Minnesota",
            "fips" => "27",
            "lon" => -94.31357,
            "lat" => 46.31189,
        ],
        [
            "abbr" => "MO",
            "name" => "Missouri",
            "fips" => "29",
            "lon" => -92.38554,
            "lat" => 38.3208,
        ],
        [
            "abbr" => "MP",
            "name" => "Northern Marianas",
            "fips" => "69",
            "lon" => 145.15796,
            "lat" => 14.57384,
        ],
        [
            "abbr" => "MS",
            "name" => "Mississippi",
            "fips" => "28",
            "lon" => -89.66553,
            "lat" => 32.75201,
        ],
        [
            "abbr" => "MT",
            "name" => "Montana",
            "fips" => "30",
            "lon" => -109.64507,
            "lat" => 47.0335,
        ],
        [
            "abbr" => "NC",
            "name" => "North Carolina",
            "fips" => "37",
            "lon" => -79.37865,
            "lat" => 35.54369,
        ],
        [
            "abbr" => "ND",
            "name" => "North Dakota",
            "fips" => "38",
            "lon" => -100.46935,
            "lat" => 47.44626,
        ],
        [
            "abbr" => "NE",
            "name" => "Nebraska",
            "fips" => "31",
            "lon" => -99.81058,
            "lat" => 41.52709,
        ],
        [
            "abbr" => "NH",
            "name" => "New Hampshire",
            "fips" => "33",
            "lon" => -71.57754,
            "lat" => 43.68556,
        ],
        [
            "abbr" => "NJ",
            "name" => "New Jersey",
            "fips" => "34",
            "lon" => -74.66876,
            "lat" => 40.20049,
        ],
        [
            "abbr" => "NM",
            "name" => "New Mexico",
            "fips" => "35",
            "lon" => -106.10837,
            "lat" => 34.42137,
        ],
        [
            "abbr" => "NV",
            "name" => "Nevada",
            "fips" => "32",
            "lon" => -116.65539,
            "lat" => 39.35648,
        ],
        [
            "abbr" => "NY",
            "name" => "New York",
            "fips" => "36",
            "lon" => -75.51491,
            "lat" => 42.94796,
        ],
        [
            "abbr" => "OH",
            "name" => "Ohio",
            "fips" => "39",
            "lon" => -82.79002,
            "lat" => 40.2912,
        ],
        [
            "abbr" => "OK",
            "name" => "Oklahoma",
            "fips" => "40",
            "lon" => -97.50819,
            "lat" => 35.58345,
        ],
        [
            "abbr" => "OR",
            "name" => "Oregon",
            "fips" => "41",
            "lon" => -120.55232,
            "lat" => 43.93589,
        ],
        [
            "abbr" => "PA",
            "name" => "Pennsylvania",
            "fips" => "42",
            "lon" => -77.7993,
            "lat" => 40.87368,
        ],
        [
            "abbr" => "PR",
            "name" => "Puerto Rico",
            "fips" => "72",
            "lon" => -66.46912,
            "lat" => 18.2224,
        ],
        [
            "abbr" => "RI",
            "name" => "Rhode Island",
            "fips" => "44",
            "lon" => -71.55579,
            "lat" => 41.67544,
        ],
        [
            "abbr" => "SC",
            "name" => "South Carolina",
            "fips" => "45",
            "lon" => -80.89899,
            "lat" => 33.93574,
        ],
        [
            "abbr" => "SD",
            "name" => "South Dakota",
            "fips" => "46",
            "lon" => -100.23048,
            "lat" => 44.43614,
        ],
        [
            "abbr" => "TN",
            "name" => "Tennessee",
            "fips" => "47",
            "lon" => -86.34332,
            "lat" => 35.84299,
        ],
        [
            "abbr" => "TX",
            "name" => "Texas",
            "fips" => "48",
            "lon" => -99.35939,
            "lat" => 31.49422,
        ],
        [
            "abbr" => "UT",
            "name" => "Utah",
            "fips" => "49",
            "lon" => -111.67822,
            "lat" => 39.32379,
        ],
        [
            "abbr" => "VA",
            "name" => "Virginia",
            "fips" => "51",
            "lon" => -78.82957,
            "lat" => 37.51637,
        ],
        [
            "abbr" => "VI",
            "name" => "Virgin Islands",
            "fips" => "78",
            "lon" => -64.80128,
            "lat" => 17.96397,
        ],
        [
            "abbr" => "VT",
            "name" => "Vermont",
            "fips" => "50",
            "lon" => -72.66273,
            "lat" => 44.07511,
        ],
        [
            "abbr" => "WA",
            "name" => "Washington",
            "fips" => "53",
            "lon" => -120.43997,
            "lat" => 47.38076,
        ],
        [
            "abbr" => "WI",
            "name" => "Wisconsin",
            "fips" => "55",
            "lon" => -90.01144,
            "lat" => 44.63725,
        ],
        [
            "abbr" => "WV",
            "name" => "West Virginia",
            "fips" => "54",
            "lon" => -80.61372,
            "lat" => 38.64259,
        ],
        [
            "abbr" => "WY",
            "name" => "Wyoming",
            "fips" => "56",
            "lon" => -107.55144,
            "lat" => 42.99963,
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        print "Preparing to seed 'states' table with " . count($this->states) . " values..\n";
        for($i=0; $i<count($this->states); $i++) {
            if (count(DB::table('states')->where('name', '=', $this->states[$i]['name'])->get()) === 0) {
                DB::table('states')->insert($this->states[$i]);
                print 'Data for "' . $this->states[$i]['name'] . '" added to database.' . "\n";
            } else {
                print 'Data for "' . $this->states[$i]['name'] . '" already exists, skipping..' . "\n";
            }
        }
    }

}
