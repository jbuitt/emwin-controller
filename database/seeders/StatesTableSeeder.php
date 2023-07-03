<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\State;

class StatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
		State::create([
			"abbr" => "AK",
			"name" => "Alaska",
			"fips" => "02",
			"lon" => -152.24098,
			"lat" => 64.24019,
		]);
		State::create([
			"abbr" => "AL",
			"name" => "Alabama",
			"fips" => "01",
			"lon" => -86.82676,
			"lat" => 32.79354,
		]);
		State::create([
			"abbr" => "AR",
			"name" => "Arkansas",
			"fips" => "05",
			"lon" => -92.4392,
			"lat" => 34.89977,
		]);
		State::create([
			"abbr" => "AS",
			"name" => "American Samoa",
			"fips" => "60",
			"lon" => -170.37215,
			"lat" => -14.26486,
		]);
		State::create([
			"abbr" => "AZ",
			"name" => "Arizona",
			"fips" => "04",
			"lon" => -111.66457,
			"lat" => 34.29323,
		]);
		State::create([
			"abbr" => "CA",
			"name" => "California",
			"fips" => "06",
			"lon" => -119.60818,
			"lat" => 37.24537,
		]);
		State::create([
			"abbr" => "CO",
			"name" => "Colorado",
			"fips" => "08",
			"lon" => -105.54783,
			"lat" => 38.99855,
		]);
		State::create([
			"abbr" => "CT",
			"name" => "Connecticut",
			"fips" => "09",
			"lon" => -72.72623,
			"lat" => 41.62196,
		]);
		State::create([
			"abbr" => "DC",
			"name" => "District of Columbia",
			"fips" => "11",
			"lon" => -77.01464,
			"lat" => 38.90932,
		]);
		State::create([
			"abbr" => "DE",
			"name" => "Delaware",
			"fips" => "10",
			"lon" => -75.50592,
			"lat" => 38.99559,
		]);
		State::create([
			"abbr" => "FL",
			"name" => "Florida",
			"fips" => "12",
			"lon" => -82.50934,
			"lat" => 28.67402,
		]);
		State::create([
			"abbr" => "GA",
			"name" => "Georgia",
			"fips" => "13",
			"lon" => -83.44848,
			"lat" => 32.65155,
		]);
		State::create([
			"abbr" => "GU",
			"name" => "Guam",
			"fips" => "66",
			"lon" => 145.15796,
			"lat" => 14.57384,
		]);
		State::create([
			"abbr" => "HI",
			"name" => "Hawaii",
			"fips" => "15",
			"lon" => -156.34743,
			"lat" => 20.24923,
		]);
		State::create([
			"abbr" => "IA",
			"name" => "Iowa",
			"fips" => "19",
			"lon" => -93.50003,
			"lat" => 42.07463,
		]);
		State::create([
			"abbr" => "ID",
			"name" => "Idaho",
			"fips" => "16",
			"lon" => -114.65933,
			"lat" => 44.38907,
		]);
		State::create([
			"abbr" => "IL",
			"name" => "Illinois",
			"fips" => "17",
			"lon" => -89.19838,
			"lat" => 40.06501,
		]);
		State::create([
			"abbr" => "IN",
			"name" => "Indiana",
			"fips" => "18",
			"lon" => -86.27548,
			"lat" => 39.90801,
		]);
		State::create([
			"abbr" => "KS",
			"name" => "Kansas",
			"fips" => "20",
			"lon" => -98.38019,
			"lat" => 38.48471,
		]);
		State::create([
			"abbr" => "KY",
			"name" => "Kentucky",
			"fips" => "21",
			"lon" => -85.29046,
			"lat" => 37.52668,
		]);
		State::create([
			"abbr" => "LA",
			"name" => "Louisiana",
			"fips" => "22",
			"lon" => -92.02905,
			"lat" => 31.0891,
		]);
		State::create([
			"abbr" => "MA",
			"name" => "Massachusetts",
			"fips" => "25",
			"lon" => -71.81423,
			"lat" => 42.25788,
		]);
		State::create([
			"abbr" => "MD",
			"name" => "Maryland",
			"fips" => "24",
			"lon" => -76.78588,
			"lat" => 39.04533,
		]);
		State::create([
			"abbr" => "ME",
			"name" => "Maine",
			"fips" => "23",
			"lon" => -69.22999,
			"lat" => 45.38046,
		]);
		State::create([
			"abbr" => "MI",
			"name" => "Michigan",
			"fips" => "26",
			"lon" => -85.43675,
			"lat" => 44.34717,
		]);
		State::create([
			"abbr" => "MN",
			"name" => "Minnesota",
			"fips" => "27",
			"lon" => -94.31357,
			"lat" => 46.31189,
		]);
		State::create([
			"abbr" => "MO",
			"name" => "Missouri",
			"fips" => "29",
			"lon" => -92.38554,
			"lat" => 38.3208,
		]);
		State::create([
			"abbr" => "MP",
			"name" => "Northern Marianas",
			"fips" => "69",
			"lon" => 145.15796,
			"lat" => 14.57384,
		]);
		State::create([
			"abbr" => "MS",
			"name" => "Mississippi",
			"fips" => "28",
			"lon" => -89.66553,
			"lat" => 32.75201,
		]);
		State::create([
			"abbr" => "MT",
			"name" => "Montana",
			"fips" => "30",
			"lon" => -109.64507,
			"lat" => 47.0335,
		]);
		State::create([
			"abbr" => "NC",
			"name" => "North Carolina",
			"fips" => "37",
			"lon" => -79.37865,
			"lat" => 35.54369,
		]);
		State::create([
			"abbr" => "ND",
			"name" => "North Dakota",
			"fips" => "38",
			"lon" => -100.46935,
			"lat" => 47.44626,
		]);
		State::create([
			"abbr" => "NE",
			"name" => "Nebraska",
			"fips" => "31",
			"lon" => -99.81058,
			"lat" => 41.52709,
		]);
		State::create([
			"abbr" => "NH",
			"name" => "New Hampshire",
			"fips" => "33",
			"lon" => -71.57754,
			"lat" => 43.68556,
		]);
		State::create([
			"abbr" => "NJ",
			"name" => "New Jersey",
			"fips" => "34",
			"lon" => -74.66876,
			"lat" => 40.20049,
		]);
		State::create([
			"abbr" => "NM",
			"name" => "New Mexico",
			"fips" => "35",
			"lon" => -106.10837,
			"lat" => 34.42137,
		]);
		State::create([
			"abbr" => "NV",
			"name" => "Nevada",
			"fips" => "32",
			"lon" => -116.65539,
			"lat" => 39.35648,
		]);
		State::create([
			"abbr" => "NY",
			"name" => "New York",
			"fips" => "36",
			"lon" => -75.51491,
			"lat" => 42.94796,
		]);
		State::create([
			"abbr" => "OH",
			"name" => "Ohio",
			"fips" => "39",
			"lon" => -82.79002,
			"lat" => 40.2912,
		]);
		State::create([
			"abbr" => "OK",
			"name" => "Oklahoma",
			"fips" => "40",
			"lon" => -97.50819,
			"lat" => 35.58345,
		]);
		State::create([
			"abbr" => "OR",
			"name" => "Oregon",
			"fips" => "41",
			"lon" => -120.55232,
			"lat" => 43.93589,
		]);
		State::create([
			"abbr" => "PA",
			"name" => "Pennsylvania",
			"fips" => "42",
			"lon" => -77.7993,
			"lat" => 40.87368,
		]);
		State::create([
			"abbr" => "PR",
			"name" => "Puerto Rico",
			"fips" => "72",
			"lon" => -66.46912,
			"lat" => 18.2224,
		]);
		State::create([
			"abbr" => "RI",
			"name" => "Rhode Island",
			"fips" => "44",
			"lon" => -71.55579,
			"lat" => 41.67544,
		]);
		State::create([
			"abbr" => "SC",
			"name" => "South Carolina",
			"fips" => "45",
			"lon" => -80.89899,
			"lat" => 33.93574,
		]);
		State::create([
			"abbr" => "SD",
			"name" => "South Dakota",
			"fips" => "46",
			"lon" => -100.23048,
			"lat" => 44.43614,
		]);
		State::create([
			"abbr" => "TN",
			"name" => "Tennessee",
			"fips" => "47",
			"lon" => -86.34332,
			"lat" => 35.84299,
		]);
		State::create([
			"abbr" => "TX",
			"name" => "Texas",
			"fips" => "48",
			"lon" => -99.35939,
			"lat" => 31.49422,
		]);
		State::create([
			"abbr" => "UT",
			"name" => "Utah",
			"fips" => "49",
			"lon" => -111.67822,
			"lat" => 39.32379,
		]);
		State::create([
			"abbr" => "VA",
			"name" => "Virginia",
			"fips" => "51",
			"lon" => -78.82957,
			"lat" => 37.51637,
		]);
		State::create([
			"abbr" => "VI",
			"name" => "Virgin Islands",
			"fips" => "78",
			"lon" => -64.80128,
			"lat" => 17.96397,
		]);
		State::create([
			"abbr" => "VT",
			"name" => "Vermont",
			"fips" => "50",
			"lon" => -72.66273,
			"lat" => 44.07511,
		]);
		State::create([
			"abbr" => "WA",
			"name" => "Washington",
			"fips" => "53",
			"lon" => -120.43997,
			"lat" => 47.38076,
		]);
		State::create([
			"abbr" => "WI",
			"name" => "Wisconsin",
			"fips" => "55",
			"lon" => -90.01144,
			"lat" => 44.63725,
		]);
		State::create([
			"abbr" => "WV",
			"name" => "West Virginia",
			"fips" => "54",
			"lon" => -80.61372,
			"lat" => 38.64259,
		]);
		State::create([
			"abbr" => "WY",
			"name" => "Wyoming",
			"fips" => "56",
			"lon" => -107.55144,
			"lat" => 42.99963,
		]);
    }
}
