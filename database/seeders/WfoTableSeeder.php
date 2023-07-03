<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Wfo;

class WfoTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
		Wfo::create([
			"abbr" => "NCF",
			"fullname" => "NCEP",
			"state" => "MD",
			"tz" => "E",
			"url" => "https://www.weather.gov/ncep",
			"rid" => "ncf",
		]);
		Wfo::create([
			"abbr" => "AAQ",
			"fullname" => "PALMER",
			"state" => "AK",
			"tz" => "A",
			"url" => "https://www.tsunami.gov",
			"rid" => "aaq",
		]);
		Wfo::create([
			"abbr" => "ABQ",
			"fullname" => "ALBUQUERQUE",
			"state" => "NM",
			"tz" => "M",
			"url" => "http://www.srh.noaa.gov/abq",
			"rid" => "abx",
		]);
		Wfo::create([
			"abbr" => "ABR",
			"fullname" => "ABERDEEN",
			"state" => "SD",
			"tz" => "C",
			"url" => "http://www.crh.noaa.gov/abr",
			"rid" => "abr",
		]);
		Wfo::create([
			"abbr" => "AFC",
			"fullname" => "ANCHORAGE",
			"state" => "AK",
			"tz" => "A",
			"url" => "http://pafc.arh.noaa.gov/",
			"rid" => "ahg",
		]);
		Wfo::create([
			"abbr" => "AFG",
			"fullname" => "FAIRBANKS",
			"state" => "AK",
			"tz" => "A",
			"url" => "http://pafg.arh.noaa.gov/",
			"rid" => "apd",
		]);
		Wfo::create([
			"abbr" => "AJK",
			"fullname" => "JUNEAU",
			"state" => "AK",
			"tz" => "A",
			"url" => "http://pajk.arh.noaa.gov/",
			"rid" => "acg",
		]);
		Wfo::create([
			"abbr" => "AKQ",
			"fullname" => "NORFOLK",
			"state" => "VA",
			"tz" => "E",
			"url" => "http://www.erh.noaa.gov/er/akq",
			"rid" => "akq",
		]);
		Wfo::create([
			"abbr" => "ALY",
			"fullname" => "ALBANY",
			"state" => "NY",
			"tz" => "E",
			"url" => "http://www.erh.noaa.gov/er/aly",
			"rid" => "enx",
		]);
		Wfo::create([
			"abbr" => "AMA",
			"fullname" => "AMARILLO",
			"state" => "TX",
			"tz" => "C",
			"url" => "http://www.srh.noaa.gov/ama",
			"rid" => "ama",
		]);
		Wfo::create([
			"abbr" => "APX",
			"fullname" => "GAYLORD",
			"state" => "MI",
			"tz" => "E",
			"url" => "http://www.crh.noaa.gov/apx",
			"rid" => "apx",
		]);
		Wfo::create([
			"abbr" => "ARX",
			"fullname" => "LA CROSSE",
			"state" => "WI",
			"tz" => "C",
			"url" => "http://www.crh.noaa.gov/arx",
			"rid" => "arx",
		]);
		Wfo::create([
			"abbr" => "BGM",
			"fullname" => "BINGHAMTON",
			"state" => "NY",
			"tz" => "E",
			"url" => "http://www.erh.noaa.gov/er/bgm",
			"rid" => "bgm",
		]);
		Wfo::create([
			"abbr" => "BIS",
			"fullname" => "BISMARCK",
			"state" => "ND",
			"tz" => "C",
			"url" => "http://www.crh.noaa.gov/bis",
			"rid" => "bis",
		]);
		Wfo::create([
			"abbr" => "BMX",
			"fullname" => "BIRMINGHAM",
			"state" => "AL",
			"tz" => "C",
			"url" => "http://www.srh.noaa.gov/bmx",
			"rid" => "bmx",
		]);
		Wfo::create([
			"abbr" => "BOI",
			"fullname" => "BOISE",
			"state" => "ID",
			"tz" => "M",
			"url" => "http://www.wrh.noaa.gov/boi",
			"rid" => "cbx",
		]);
		Wfo::create([
			"abbr" => "BOU",
			"fullname" => "BOULDER",
			"state" => "CO",
			"tz" => "M",
			"url" => "http://www.crh.noaa.gov/bou",
			"rid" => "ftg",
		]);
		Wfo::create([
			"abbr" => "BOX",
			"fullname" => "BOSTON",
			"state" => "MA",
			"tz" => "E",
			"url" => "http://www.erh.noaa.gov/er/box",
			"rid" => "box",
		]);
		Wfo::create([
			"abbr" => "BRO",
			"fullname" => "BROWNSVILLE",
			"state" => "TX",
			"tz" => "C",
			"url" => "http://www.srh.noaa.gov/bro",
			"rid" => "bro",
		]);
		Wfo::create([
			"abbr" => "BTV",
			"fullname" => "BURLINGTON",
			"state" => "VT",
			"tz" => "E",
			"url" => "http://www.erh.noaa.gov/er/btv",
			"rid" => "cxx",
		]);
		Wfo::create([
			"abbr" => "BUF",
			"fullname" => "BUFFALO",
			"state" => "NY",
			"tz" => "E",
			"url" => "http://www.erh.noaa.gov/er/buf",
			"rid" => "buf",
		]);
		Wfo::create([
			"abbr" => "BYZ",
			"fullname" => "BILLINGS",
			"state" => "MT",
			"tz" => "M",
			"url" => "http://www.wrh.noaa.gov/byz",
			"rid" => "blx",
		]);
		Wfo::create([
			"abbr" => "CAE",
			"fullname" => "COLUMBIA",
			"state" => "SC",
			"tz" => "E",
			"url" => "http://www.erh.noaa.gov/er/cae",
			"rid" => "cae",
		]);
		Wfo::create([
			"abbr" => "CAR",
			"fullname" => "CARIBOU",
			"state" => "ME",
			"tz" => "E",
			"url" => "http://www.erh.noaa.gov/er/car",
			"rid" => "cbw",
		]);
		Wfo::create([
			"abbr" => "CHS",
			"fullname" => "CHARLESTON",
			"state" => "SC",
			"tz" => "E",
			"url" => "http://www.erh.noaa.gov/er/chs",
			"rid" => "clx",
		]);
		Wfo::create([
			"abbr" => "CLE",
			"fullname" => "CLEVELAND",
			"state" => "OH",
			"tz" => "E",
			"url" => "http://www.erh.noaa.gov/er/cle",
			"rid" => "cle",
		]);
		Wfo::create([
			"abbr" => "CRP",
			"fullname" => "CORPUS CHRISTI",
			"state" => "TX",
			"tz" => "C",
			"url" => "http://www.srh.noaa.gov/crp",
			"rid" => "crp",
		]);
		Wfo::create([
			"abbr" => "CTP",
			"fullname" => "STATE COLLEGE",
			"state" => "PA",
			"tz" => "E",
			"url" => "http://www.erh.noaa.gov/er/ctp",
			"rid" => "ccx",
		]);
		Wfo::create([
			"abbr" => "CYS",
			"fullname" => "CHEYENNE",
			"state" => "WY",
			"tz" => "M",
			"url" => "http://www.crh.noaa.gov/cys",
			"rid" => "cys",
		]);
		Wfo::create([
			"abbr" => "DDC",
			"fullname" => "DODGE CITY",
			"state" => "KS",
			"tz" => "C",
			"url" => "http://www.crh.noaa.gov/ddc",
			"rid" => "ddc",
		]);
		Wfo::create([
			"abbr" => "DLH",
			"fullname" => "DULUTH",
			"state" => "MN",
			"tz" => "C",
			"url" => "http://www.crh.noaa.gov/dlh",
			"rid" => "dlh",
		]);
		Wfo::create([
			"abbr" => "DMX",
			"fullname" => "DES MOINES",
			"state" => "IA",
			"tz" => "C",
			"url" => "http://www.crh.noaa.gov/dmx",
			"rid" => "dmx",
		]);
		Wfo::create([
			"abbr" => "DTX",
			"fullname" => "DETROIT / PONTIAC",
			"state" => "MI",
			"tz" => "E",
			"url" => "http://www.crh.noaa.gov/dtx",
			"rid" => "dtx",
		]);
		Wfo::create([
			"abbr" => "DVN",
			"fullname" => "DAVENPORT / QUAD CITIES",
			"state" => "IA",
			"tz" => "C",
			"url" => "http://www.crh.noaa.gov/dvn",
			"rid" => "dvn",
		]);
		Wfo::create([
			"abbr" => "EAX",
			"fullname" => "PLEASANT HILL / KANSAS CITY",
			"state" => "MO",
			"tz" => "C",
			"url" => "http://www.crh.noaa.gov/eax",
			"rid" => "eax",
		]);
		Wfo::create([
			"abbr" => "EKA",
			"fullname" => "EUREKA",
			"state" => "CA",
			"tz" => "P",
			"url" => "http://www.wrh.noaa.gov/eka",
			"rid" => "bhx",
		]);
		Wfo::create([
			"abbr" => "EPZ",
			"fullname" => "SANTA TERESA",
			"state" => "NM",
			"tz" => "M",
			"url" => "http://www.srh.noaa.gov/epz",
			"rid" => "epz",
		]);
		Wfo::create([
			"abbr" => "EWX",
			"fullname" => "NEW BRAUNFELS",
			"state" => "TX",
			"tz" => "C",
			"url" => "http://www.srh.noaa.gov/ewx",
			"rid" => "ewx",
		]);
		Wfo::create([
			"abbr" => "FFC",
			"fullname" => "PEACHTREE CITY",
			"state" => "GA",
			"tz" => "E",
			"url" => "http://www.srh.noaa.gov/ffc",
			"rid" => "ffc",
		]);
		Wfo::create([
			"abbr" => "FGF",
			"fullname" => "FARGO / GRAND FORKS",
			"state" => "ND",
			"tz" => "C",
			"url" => "http://www.crh.noaa.gov/fgf",
			"rid" => "mvx",
		]);
		Wfo::create([
			"abbr" => "FGZ",
			"fullname" => "FLAGSTAFF",
			"state" => "AZ",
			"tz" => "M",
			"url" => "http://www.wrh.noaa.gov/fgz",
			"rid" => "fsx",
		]);
		Wfo::create([
			"abbr" => "FSD",
			"fullname" => "SIOUX FALLS",
			"state" => "SD",
			"tz" => "C",
			"url" => "http://www.crh.noaa.gov/fsd",
			"rid" => "fsd",
		]);
		Wfo::create([
			"abbr" => "FWD",
			"fullname" => "FORT WORTH",
			"state" => "TX",
			"tz" => "C",
			"url" => "http://www.srh.noaa.gov/fwd",
			"rid" => "fws",
		]);
		Wfo::create([
			"abbr" => "GGW",
			"fullname" => "GLASGOW",
			"state" => "MT",
			"tz" => "M",
			"url" => "http://www.wrh.noaa.gov/ggw",
			"rid" => "ggw",
		]);
		Wfo::create([
			"abbr" => "GID",
			"fullname" => "GRAND ISLAND",
			"state" => "NE",
			"tz" => "C",
			"url" => "http://www.crh.noaa.gov/gid",
			"rid" => "uex",
		]);
		Wfo::create([
			"abbr" => "GJT",
			"fullname" => "GRAND JUNCTION",
			"state" => "CO",
			"tz" => "M",
			"url" => "http://www.crh.noaa.gov/gjt",
			"rid" => "gjx",
		]);
		Wfo::create([
			"abbr" => "GLD",
			"fullname" => "GOODLAND",
			"state" => "KS",
			"tz" => "C",
			"url" => "http://www.crh.noaa.gov/gld",
			"rid" => "gld",
		]);
		Wfo::create([
			"abbr" => "GRB",
			"fullname" => "ASHWAUBENON",
			"state" => "WI",
			"tz" => "C",
			"url" => "http://www.crh.noaa.gov/grb",
			"rid" => "grb",
		]);
		Wfo::create([
			"abbr" => "GRR",
			"fullname" => "GRAND RAPIDS",
			"state" => "MI",
			"tz" => "E",
			"url" => "http://www.crh.noaa.gov/grr",
			"rid" => "grr",
		]);
		Wfo::create([
			"abbr" => "GSP",
			"fullname" => "GREER / SPARTANSBURG",
			"state" => "SC",
			"tz" => "E",
			"url" => "http://www.erh.noaa.gov/er/gsp",
			"rid" => "gsp",
		]);
		Wfo::create([
			"abbr" => "GYX",
			"fullname" => "PORTLAND",
			"state" => "ME",
			"tz" => "E",
			"url" => "http://www.erh.noaa.gov/er/gyx",
			"rid" => "gyx",
		]);
		Wfo::create([
			"abbr" => "GUM",
			"fullname" => "TYAN",
			"state" => "GU",
			"tz" => "G",
			"url" => "http://www.prh.noaa.gov/guam/",
			"rid" => "gum",
		]);
		Wfo::create([
			"abbr" => "HEB",
			"fullname" => "EWA BEACH",
			"state" => "HI",
			"tz" => "H",
			"url" => "https://www.tsunami.gov",
			"rid" => "heb",
		]);
		Wfo::create([
			"abbr" => "HFO",
			"fullname" => "HONOLULU",
			"state" => "HI",
			"tz" => "H",
			"url" => "http://www.prh.noaa.gov/pr/hnl/",
			"rid" => "hmo",
		]);
		Wfo::create([
			"abbr" => "HGX",
			"fullname" => "HOUSTON / DICKINSON",
			"state" => "TX",
			"tz" => "C",
			"url" => "http://www.srh.noaa.gov/hgx",
			"rid" => "hgx",
		]);
		Wfo::create([
			"abbr" => "HNX",
			"fullname" => "HANFORD / SAN JOAQUIN VALLEY",
			"state" => "CA",
			"tz" => "P",
			"url" => "http://www.srh.noaa.gov/hnx",
			"rid" => "hnx",
		]);
		Wfo::create([
			"abbr" => "HUN",
			"fullname" => "HUNTSVILLE",
			"state" => "AL",
			"tz" => "C",
			"url" => "http://www.srh.noaa.gov/hun",
			"rid" => "htx",
		]);
		Wfo::create([
			"abbr" => "ICT",
			"fullname" => "WICHITA",
			"state" => "KS",
			"tz" => "C",
			"url" => "http://www.crh.noaa.gov/ict",
			"rid" => "ict",
		]);
		Wfo::create([
			"abbr" => "ILM",
			"fullname" => "WILMINGTON",
			"state" => "NC",
			"tz" => "E",
			"url" => "http://www.erh.noaa.gov/er/ilm",
			"rid" => "ltx",
		]);
		Wfo::create([
			"abbr" => "ILN",
			"fullname" => "WILMINGTON",
			"state" => "OH",
			"tz" => "E",
			"url" => "http://www.erh.noaa.gov/er/iln",
			"rid" => "iln",
		]);
		Wfo::create([
			"abbr" => "ILX",
			"fullname" => "LINCOLN",
			"state" => "IL",
			"tz" => "C",
			"url" => "http://www.crh.noaa.gov/ilx",
			"rid" => "ilx",
		]);
		Wfo::create([
			"abbr" => "IND",
			"fullname" => "INDIANAPOLIS",
			"state" => "IN",
			"tz" => "E",
			"url" => "http://www.crh.noaa.gov/ind",
			"rid" => "ind",
		]);
		Wfo::create([
			"abbr" => "IWX",
			"fullname" => "NORTH WEBSTER",
			"state" => "IN",
			"tz" => "E",
			"url" => "http://www.crh.noaa.gov/iwx",
			"rid" => "iwx",
		]);
		Wfo::create([
			"abbr" => "JAN",
			"fullname" => "JACKSON",
			"state" => "MS",
			"tz" => "C",
			"url" => "http://www.srh.noaa.gov/jan",
			"rid" => "dgx",
		]);
		Wfo::create([
			"abbr" => "JAX",
			"fullname" => "JACKSONVILLE",
			"state" => "FL",
			"tz" => "E",
			"url" => "http://www.srh.noaa.gov/jax",
			"rid" => "jax",
		]);
		Wfo::create([
			"abbr" => "JKL",
			"fullname" => "JACKSON",
			"state" => "KY",
			"tz" => "E",
			"url" => "http://www.crh.noaa.gov/jkl",
			"rid" => "jkl",
		]);
		Wfo::create([
			"abbr" => "JSJ",
			"fullname" => "SAN JUAN",
			"state" => "PR",
			"tz" => "E",
			"url" => "http://www.srh.noaa.gov/sju",
			"rid" => "jua",
		]);
		Wfo::create([
			"abbr" => "KEY",
			"fullname" => "KEY WEST",
			"state" => "FL",
			"tz" => "E",
			"url" => "http://www.srh.noaa.gov/key",
			"rid" => "byx",
		]);
		Wfo::create([
			"abbr" => "LBF",
			"fullname" => "NORTH PLATTE",
			"state" => "NE",
			"tz" => "C",
			"url" => "http://www.crh.noaa.gov/lbf",
			"rid" => "lnx",
		]);
		Wfo::create([
			"abbr" => "LCH",
			"fullname" => "LAKE CHARLES",
			"state" => "LA",
			"tz" => "C",
			"url" => "http://www.srh.noaa.gov/lch",
			"rid" => "lch",
		]);
		Wfo::create([
			"abbr" => "LIX",
			"fullname" => "SLIDELL",
			"state" => "LA",
			"tz" => "C",
			"url" => "http://www.srh.noaa.gov/lix",
			"rid" => "lix",
		]);
		Wfo::create([
			"abbr" => "LKN",
			"fullname" => "ELKO",
			"state" => "NV",
			"tz" => "P",
			"url" => "http://www.wrh.noaa.gov/lkn",
			"rid" => "lrx",
		]);
		Wfo::create([
			"abbr" => "LMK",
			"fullname" => "LOUISVILLE",
			"state" => "KY",
			"tz" => "E",
			"url" => "http://www.crh.noaa.gov/lmk",
			"rid" => "lvx",
		]);
		Wfo::create([
			"abbr" => "LOT",
			"fullname" => "CHICAGO",
			"state" => "IL",
			"tz" => "C",
			"url" => "http://www.crh.noaa.gov/lot",
			"rid" => "lot",
		]);
		Wfo::create([
			"abbr" => "LOX",
			"fullname" => "LOS ANGELES",
			"state" => "CA",
			"tz" => "P",
			"url" => "http://www.srh.noaa.gov/lox",
			"rid" => "lix",
		]);
		Wfo::create([
			"abbr" => "LSX",
			"fullname" => "ST LOUIS",
			"state" => "MO",
			"tz" => "C",
			"url" => "http://www.crh.noaa.gov/lsx",
			"rid" => "lsx",
		]);
		Wfo::create([
			"abbr" => "LUB",
			"fullname" => "LUBBOCK",
			"state" => "TX",
			"tz" => "C",
			"url" => "http://www.srh.noaa.gov/lub",
			"rid" => "lbb",
		]);
		Wfo::create([
			"abbr" => "LWX",
			"fullname" => "STERLING",
			"state" => "VA",
			"tz" => "E",
			"url" => "http://www.erh.noaa.gov/er/lwx",
			"rid" => "lwx",
		]);
		Wfo::create([
			"abbr" => "LZK",
			"fullname" => "LITTLE ROCK",
			"state" => "AR",
			"tz" => "C",
			"url" => "http://www.srh.noaa.gov/lzk",
			"rid" => "lzk",
		]);
		Wfo::create([
			"abbr" => "MAF",
			"fullname" => "MIDLAND",
			"state" => "TX",
			"tz" => "C",
			"url" => "http://www.srh.noaa.gov/maf",
			"rid" => "maf",
		]);
		Wfo::create([
			"abbr" => "MEG",
			"fullname" => "MEMPHIS",
			"state" => "TN",
			"tz" => "C",
			"url" => "http://www.srh.noaa.gov/meg",
			"rid" => "nqa",
		]);
		Wfo::create([
			"abbr" => "MFL",
			"fullname" => "MIAMI",
			"state" => "FL",
			"tz" => "E",
			"url" => "http://www.srh.noaa.gov/mfl",
			"rid" => "amx",
		]);
		Wfo::create([
			"abbr" => "MFR",
			"fullname" => "MEDFORD",
			"state" => "OR",
			"tz" => "P",
			"url" => "http://www.srh.noaa.gov/mfr",
			"rid" => "amx",
		]);
		Wfo::create([
			"abbr" => "MHX",
			"fullname" => "MOREHEAD CITY / NEWPORT",
			"state" => "NC",
			"tz" => "E",
			"url" => "http://www.erh.noaa.gov/er/mhx",
			"rid" => "mhx",
		]);
		Wfo::create([
			"abbr" => "MKX",
			"fullname" => "MILWAUKEE",
			"state" => "WI",
			"tz" => "C",
			"url" => "http://www.crh.noaa.gov/mkx",
			"rid" => "mkx",
		]);
		Wfo::create([
			"abbr" => "MLB",
			"fullname" => "MELBOURNE",
			"state" => "FL",
			"tz" => "E",
			"url" => "http://www.srh.noaa.gov/mlb",
			"rid" => "mlb",
		]);
		Wfo::create([
			"abbr" => "MOB",
			"fullname" => "MOBILE / PENSACOLA",
			"state" => "AL",
			"tz" => "C",
			"url" => "http://www.srh.noaa.gov/mob",
			"rid" => "mob",
		]);
		Wfo::create([
			"abbr" => "MPX",
			"fullname" => "TWIN CITIES",
			"state" => "MN",
			"tz" => "C",
			"url" => "http://www.crh.noaa.gov/mpx",
			"rid" => "mpx",
		]);
		Wfo::create([
			"abbr" => "MQT",
			"fullname" => "MARQUETTE",
			"state" => "MI",
			"tz" => "E",
			"url" => "http://www.crh.noaa.gov/mqt",
			"rid" => "mqt",
		]);
		Wfo::create([
			"abbr" => "MRX",
			"fullname" => "MORRISTOWN",
			"state" => "TN",
			"tz" => "E",
			"url" => "http://www.srh.noaa.gov/mrx",
			"rid" => "mrx",
		]);
		Wfo::create([
			"abbr" => "MSO",
			"fullname" => "MISSOULA",
			"state" => "MT",
			"tz" => "M",
			"url" => "http://www.wrh.noaa.gov/mso",
			"rid" => "msx",
		]);
		Wfo::create([
			"abbr" => "MTR",
			"fullname" => "SAN FRANCISCO BAY AREA",
			"state" => "CA",
			"tz" => "P",
			"url" => "http://www.wrh.noaa.gov/mtr",
			"rid" => "mux",
		]);
		Wfo::create([
			"abbr" => "OAX",
			"fullname" => "OMAHA/VALLEY",
			"state" => "NE",
			"tz" => "C",
			"url" => "http://www.crh.noaa.gov/oax",
			"rid" => "oax",
		]);
		Wfo::create([
			"abbr" => "OHX",
			"fullname" => "NASHVILLE",
			"state" => "TN",
			"tz" => "C",
			"url" => "http://www.srh.noaa.gov/ohx",
			"rid" => "ohx",
		]);
		Wfo::create([
			"abbr" => "OKX",
			"fullname" => "UPTON / NEW YORK CITY",
			"state" => "NY",
			"tz" => "E",
			"url" => "http://www.erh.noaa.gov/er/okx",
			"rid" => "okx",
		]);
		Wfo::create([
			"abbr" => "OTX",
			"fullname" => "SPOKANE",
			"state" => "WA",
			"tz" => "P",
			"url" => "http://www.srh.noaa.gov/otx",
			"rid" => "ohx",
		]);
		Wfo::create([
			"abbr" => "OUN",
			"fullname" => "NORMAN",
			"state" => "OK",
			"tz" => "C",
			"url" => "http://www.srh.noaa.gov/oun",
			"rid" => "tlx",
		]);
		Wfo::create([
			"abbr" => "PAH",
			"fullname" => "PADUCAH",
			"state" => "KY",
			"tz" => "C",
			"url" => "http://www.crh.noaa.gov/pah",
			"rid" => "pah",
		]);
		Wfo::create([
			"abbr" => "PBZ",
			"fullname" => "PITTSBURGH",
			"state" => "PA",
			"tz" => "E",
			"url" => "http://www.erh.noaa.gov/er/pbz",
			"rid" => "pbz",
		]);
		Wfo::create([
			"abbr" => "PDT",
			"fullname" => "PENDLETON",
			"state" => "OR",
			"tz" => "P",
			"url" => "http://www.wrh.noaa.gov/pdt",
			"rid" => "pdt",
		]);
		Wfo::create([
			"abbr" => "PHI",
			"fullname" => "MT HOLLY / PHILADELPHIA",
			"state" => "PA",
			"tz" => "E",
			"url" => "http://www.erh.noaa.gov/er/phi",
			"rid" => "dix",
		]);
		Wfo::create([
			"abbr" => "PIH",
			"fullname" => "POCATELLO",
			"state" => "ID",
			"tz" => "M",
			"url" => "http://www.wrh.noaa.gov/pih",
			"rid" => "sfx",
		]);
		Wfo::create([
			"abbr" => "PQR",
			"fullname" => "PORTLAND",
			"state" => "OR",
			"tz" => "P",
			"url" => "http://www.wrh.noaa.gov/pqr",
			"rid" => "rtx",
		]);
		Wfo::create([
			"abbr" => "PSR",
			"fullname" => "PHOENIX",
			"state" => "AZ",
			"tz" => "M",
			"url" => "http://www.wrh.noaa.gov/psr",
			"rid" => "iwa",
		]);
		Wfo::create([
			"abbr" => "PUB",
			"fullname" => "PUEBLO",
			"state" => "CO",
			"tz" => "M",
			"url" => "http://www.crh.noaa.gov/pub",
			"rid" => "pux",
		]);
		Wfo::create([
			"abbr" => "RAH",
			"fullname" => "RALEIGH",
			"state" => "NC",
			"tz" => "E",
			"url" => "http://www.erh.noaa.gov/er/rah",
			"rid" => "rax",
		]);
		Wfo::create([
			"abbr" => "REV",
			"fullname" => "RENO",
			"state" => "NV",
			"tz" => "P",
			"url" => "http://www.wrh.noaa.gov/rev",
			"rid" => "rgx",
		]);
		Wfo::create([
			"abbr" => "RIW",
			"fullname" => "RIVERTON",
			"state" => "WY",
			"tz" => "M",
			"url" => "http://www.crh.noaa.gov/riw",
			"rid" => "riw",
		]);
		Wfo::create([
			"abbr" => "RLX",
			"fullname" => "CHARLESTON",
			"state" => "WV",
			"tz" => "E",
			"url" => "http://www.erh.noaa.gov/er/rlx",
			"rid" => "rlx",
		]);
		Wfo::create([
			"abbr" => "RNK",
			"fullname" => "BLACKSBURG",
			"state" => "VA",
			"tz" => "E",
			"url" => "http://www.erh.noaa.gov/er/rnk",
			"rid" => "fcx",
		]);
		Wfo::create([
			"abbr" => "SDM",
			"fullname" => "COLLEGE PARK",
			"state" => "MD",
			"tz" => "E",
			"url" => "https://www.nco.ncep.noaa.gov",
			"rid" => "sdm",
		]);
		Wfo::create([
			"abbr" => "SEW",
			"fullname" => "SEATTLE",
			"state" => "WA",
			"tz" => "P",
			"url" => "http://www.wrh.noaa.gov/sew",
			"rid" => "atx",
		]);
		Wfo::create([
			"abbr" => "SGF",
			"fullname" => "SPRINGFIELD",
			"state" => "MO",
			"tz" => "C",
			"url" => "http://www.crh.noaa.gov/sgf",
			"rid" => "sgf",
		]);
		Wfo::create([
			"abbr" => "SGX",
			"fullname" => "SAN DIEGO",
			"state" => "CA",
			"tz" => "P",
			"url" => "http://www.srh.noaa.gov/sgx",
			"rid" => "sox",
		]);
		Wfo::create([
			"abbr" => "SHV",
			"fullname" => "SHREVEPORT",
			"state" => "LA",
			"tz" => "C",
			"url" => "http://www.srh.noaa.gov/shv",
			"rid" => "shv",
		]);
		Wfo::create([
			"abbr" => "SJT",
			"fullname" => "SAN ANGELO",
			"state" => "TX",
			"tz" => "C",
			"url" => "http://www.srh.noaa.gov/sjt",
			"rid" => "dyx",
		]);
		Wfo::create([
			"abbr" => "SLC",
			"fullname" => "SALT LAKE CITY",
			"state" => "UT",
			"tz" => "M",
			"url" => "http://www.wrh.noaa.gov/slc",
			"rid" => "mtx",
		]);
		Wfo::create([
			"abbr" => "STO",
			"fullname" => "SACRAMENTO",
			"state" => "CA",
			"tz" => "P",
			"url" => "http://www.wrh.noaa.gov/sto",
			"rid" => "dax",
		]);
		Wfo::create([
			"abbr" => "TAE",
			"fullname" => "TALLAHASSEE",
			"state" => "FL",
			"tz" => "E",
			"url" => "http://www.srh.noaa.gov/tae",
			"rid" => "tlh",
		]);
		Wfo::create([
			"abbr" => "TBW",
			"fullname" => "TAMPA BAY",
			"state" => "FL",
			"tz" => "E",
			"url" => "http://www.srh.noaa.gov/tbw",
			"rid" => "tbw",
		]);
		Wfo::create([
			"abbr" => "TFX",
			"fullname" => "GREAT FALLS",
			"state" => "MT",
			"tz" => "M",
			"url" => "http://www.wrh.noaa.gov/tfx",
			"rid" => "tfx",
		]);
		Wfo::create([
			"abbr" => "TOP",
			"fullname" => "TOPEKA",
			"state" => "KS",
			"tz" => "C",
			"url" => "http://www.crh.noaa.gov/top",
			"rid" => "twx",
		]);
		Wfo::create([
			"abbr" => "TSA",
			"fullname" => "TULSA",
			"state" => "OK",
			"tz" => "C",
			"url" => "http://www.srh.noaa.gov/tsa",
			"rid" => "inx",
		]);
		Wfo::create([
			"abbr" => "TWC",
			"fullname" => "TUCSON",
			"state" => "AZ",
			"tz" => "M",
			"url" => "http://www.wrh.noaa.gov/twc",
			"rid" => "emx",
		]);
		Wfo::create([
			"abbr" => "UNR",
			"fullname" => "RAPID CITY",
			"state" => "SD",
			"tz" => "C",
			"url" => "http://www.crh.noaa.gov/unr",
			"rid" => "udx",
		]);
		Wfo::create([
			"abbr" => "VEF",
			"fullname" => "LAS VEGAS",
			"state" => "NV",
			"tz" => "P",
			"url" => "http://www.wrh.noaa.gov/vef",
			"rid" => "esx",
		]);
		Wfo::create([
			"abbr" => "WNS",
			"fullname" => "NORMAN",
			"state" => "OK",
			"tz" => "C",
			"url" => "http://www.spc.noaa.gov",
			"rid" => "spc",
		]);
    }
}
