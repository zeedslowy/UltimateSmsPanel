<?php

use Illuminate\Database\Seeder;
use App\IntCountryCodes;

class IntCountryCodesSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		IntCountryCodes::truncate();
		$value = [

			[
				'country_name' => 'Afghanistan',
				'iso_code' => 'AF / AFG',
				'country_code' => '93',
				'tariff' => '1.00',
				'active' => '1',
			],
			[
				'country_name' => 'Albania',
				'iso_code' => 'AL / ALB',
				'country_code' => '355',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Algeria',
				'iso_code' => 'DZ / DZA',
				'country_code' => '213',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Andorra',
				'iso_code' => 'AD / AND',
				'country_code' => '376',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Angola',
				'iso_code' => 'AO / AGO',
				'country_code' => '244',
				'tariff' => '1.00',
				'active' => '0'
			],
			[
				'country_name' => 'Antarctica',
				'iso_code' => 'AQ / ATA',
				'country_code' => '672',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Argentina',
				'iso_code' => 'AR / ARG',
				'country_code' => '54',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Armenia',
				'iso_code' => 'AM / ARM',
				'country_code' => '374',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Aruba',
				'iso_code' => 'AW / ABW',
				'country_code' => '297',
				'tariff' => '1.00',
				'active' => '0'
			],
			[
				'country_name' => 'Australia',
				'iso_code' => 'AU / AUS',
				'country_code' => '61',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Austria',
				'iso_code' => 'AT / AUT',
				'country_code' => '43',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Azerbaijan',
				'iso_code' => 'AZ / AZE',
				'country_code' => '994',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Bahrain',
				'iso_code' => 'BH / BHR',
				'country_code' => '973',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Bangladesh',
				'iso_code' => 'BD / BGD',
				'country_code' => '880',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Belarus',
				'iso_code' => 'BY / BLR',
				'country_code' => '375',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Belgium',
				'iso_code' => 'BE / BEL',
				'country_code' => '32',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Belize',
				'iso_code' => 'BZ / BLZ',
				'country_code' => '501',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Benin',
				'iso_code' => 'BJ / BEN',
				'country_code' => '229',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Bhutan',
				'iso_code' => 'BT / BTN',
				'country_code' => '975',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Bolivia',
				'iso_code' => 'BO / BOL',
				'country_code' => '591',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Bosnia and Herzegovina',
				'iso_code' => 'BA / BIH',
				'country_code' => '387',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Botswana',
				'iso_code' => 'BW / BWA',
				'country_code' => '267',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Brazil',
				'iso_code' => 'BR / BRA',
				'country_code' => '55',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Brunei',
				'iso_code' => 'BN / BRN',
				'country_code' => '673',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Bulgaria',
				'iso_code' => 'BG / BGR',
				'country_code' => '359',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Burkina Faso',
				'iso_code' => 'BF / BFA',
				'country_code' => '226',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Burma (Myanmar)',
				'iso_code' => 'MM / MMR',
				'country_code' => '95',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Burundi',
				'iso_code' => 'BI / BDI',
				'country_code' => '257',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Cambodia',
				'iso_code' => 'KH / KHM',
				'country_code' => '855',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Cameroon',
				'iso_code' => 'CM / CMR',
				'country_code' => '237',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Canada',
				'iso_code' => 'CA / CAN',
				'country_code' => '1',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Cape Verde',
				'iso_code' => 'CV / CPV',
				'country_code' => '238',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Central African Republic',
				'iso_code' => 'CF / CAF',
				'country_code' => '236',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Chad',
				'iso_code' => 'TD / TCD',
				'country_code' => '235',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Chile',
				'iso_code' => 'CL / CHL',
				'country_code' => '56',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'China',
				'iso_code' => 'CN / CHN',
				'country_code' => '86',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Christmas Island',
				'iso_code' => 'CX / CXR',
				'country_code' => '61',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Cocos (Keeling) Islands',
				'iso_code' => 'CC / CCK',
				'country_code' => '61',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Colombia',
				'iso_code' => 'CO / COL',
				'country_code' => '57',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Comoros',
				'iso_code' => 'KM / COM',
				'country_code' => '269',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Congo',
				'iso_code' => 'CD / COD',
				'country_code' => '243',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Cook Islands',
				'iso_code' => 'CK / COK',
				'country_code' => '682',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Costa Rica',
				'iso_code' => 'CR / CRC',
				'country_code' => '506',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Croatia',
				'iso_code' => 'HR / HRV',
				'country_code' => '385',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Cuba',
				'iso_code' => 'CU / CUB',
				'country_code' => '53',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Cyprus',
				'iso_code' => 'CY / CYP',
				'country_code' => '357',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Czech Republic',
				'iso_code' => 'CZ / CZE',
				'country_code' => '420',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Denmark',
				'iso_code' => 'DK / DNK',
				'country_code' => '45',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Djibouti',
				'iso_code' => 'DJ / DJI',
				'country_code' => '253',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Ecuador',
				'iso_code' => 'EC / ECU',
				'country_code' => '593',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Egypt',
				'iso_code' => 'EG / EGY',
				'country_code' => '20',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'El Salvador',
				'iso_code' => 'SV / SLV',
				'country_code' => '503',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Equatorial Guinea',
				'iso_code' => 'GQ / GNQ',
				'country_code' => '240',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Eritrea',
				'iso_code' => 'ER / ERI',
				'country_code' => '291',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Estonia',
				'iso_code' => 'EE / EST',
				'country_code' => '372',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Ethiopia',
				'iso_code' => 'ET / ETH',
				'country_code' => '251',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Falkland Islands',
				'iso_code' => 'FK / FLK',
				'country_code' => '500',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Faroe Islands',
				'iso_code' => 'FO / FRO',
				'country_code' => '298',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Fiji',
				'iso_code' => 'FJ / FJI',
				'country_code' => '679',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Finland',
				'iso_code' => 'FI / FIN',
				'country_code' => '358',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'France',
				'iso_code' => 'FR / FRA',
				'country_code' => '33',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'French Polynesia',
				'iso_code' => 'PF / PYF',
				'country_code' => '689',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Gabon',
				'iso_code' => 'GA / GAB',
				'country_code' => '241',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Gambia',
				'iso_code' => 'GM / GMB',
				'country_code' => '220',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Gaza Strip',
				'iso_code' => '/',
				'country_code' => '970',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Georgia',
				'iso_code' => 'GE / GEO',
				'country_code' => '995',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Germany',
				'iso_code' => 'DE / DEU',
				'country_code' => '49',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Ghana',
				'iso_code' => 'GH / GHA',
				'country_code' => '233',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Gibraltar',
				'iso_code' => 'GI / GIB',
				'country_code' => '350',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Greece',
				'iso_code' => 'GR / GRC',
				'country_code' => '30',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Greenland',
				'iso_code' => 'GL / GRL',
				'country_code' => '299',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Guatemala',
				'iso_code' => 'GT / GTM',
				'country_code' => '502',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Guinea',
				'iso_code' => 'GN / GIN',
				'country_code' => '224',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Guinea-Bissau',
				'iso_code' => 'GW / GNB',
				'country_code' => '245',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Guyana',
				'iso_code' => 'GY / GUY',
				'country_code' => '592',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Haiti',
				'iso_code' => 'HT / HTI',
				'country_code' => '509',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Holy See (Vatican City)',
				'iso_code' => 'VA / VAT',
				'country_code' => '39',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Honduras',
				'iso_code' => 'HN / HND',
				'country_code' => '504',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Hong Kong',
				'iso_code' => 'HK / HKG',
				'country_code' => '852',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Hungary',
				'iso_code' => 'HU / HUN',
				'country_code' => '36',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Iceland',
				'iso_code' => 'IS / IS',
				'country_code' => '354',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'India',
				'iso_code' => 'IN / IND',
				'country_code' => '91',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Indonesia',
				'iso_code' => 'ID / IDN',
				'country_code' => '62',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Iran',
				'iso_code' => 'IR / IRN',
				'country_code' => '98',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Iraq',
				'iso_code' => 'IQ / IRQ',
				'country_code' => '964',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Ireland',
				'iso_code' => 'IE / IRL',
				'country_code' => '353',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Isle of Man',
				'iso_code' => 'IM / IMN',
				'country_code' => '44',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Israel',
				'iso_code' => 'IL / ISR',
				'country_code' => '972',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Italy',
				'iso_code' => 'IT / ITA',
				'country_code' => '39',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Ivory Coast',
				'iso_code' => 'CI / CIV',
				'country_code' => '225',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Japan',
				'iso_code' => 'JP / JPN',
				'country_code' => '81',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Jordan',
				'iso_code' => 'JO / JOR',
				'country_code' => '962',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Kazakhstan',
				'iso_code' => 'KZ / KAZ',
				'country_code' => '7',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Kenya',
				'iso_code' => 'KE / KEN',
				'country_code' => '254',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Kiribati',
				'iso_code' => 'KI / KIR',
				'country_code' => '686',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Kosovo',
				'iso_code' => '/',
				'country_code' => '381',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Kuwait',
				'iso_code' => 'KW / KWT',
				'country_code' => '965',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Kyrgyzstan',
				'iso_code' => 'KG / KGZ',
				'country_code' => '996',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Laos',
				'iso_code' => 'LA / LAO',
				'country_code' => '856',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Latvia',
				'iso_code' => 'LV / LVA',
				'country_code' => '371',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Lebanon',
				'iso_code' => 'LB / LBN',
				'country_code' => '961',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Lesotho',
				'iso_code' => 'LS / LSO',
				'country_code' => '266',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Liberia',
				'iso_code' => 'LR / LBR',
				'country_code' => '231',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Libya',
				'iso_code' => 'LY / LBY',
				'country_code' => '218',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Liechtenstein',
				'iso_code' => 'LI / LIE',
				'country_code' => '423',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Lithuania',
				'iso_code' => 'LT / LTU',
				'country_code' => '370',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Luxembourg',
				'iso_code' => 'LU / LUX',
				'country_code' => '352',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Macau',
				'iso_code' => 'MO / MAC',
				'country_code' => '853',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Macedonia',
				'iso_code' => 'MK / MKD',
				'country_code' => '389',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Madagascar',
				'iso_code' => 'MG / MDG',
				'country_code' => '261',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Malawi',
				'iso_code' => 'MW / MWI',
				'country_code' => '265',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Malaysia',
				'iso_code' => 'MY / MYS',
				'country_code' => '60',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Maldives',
				'iso_code' => 'MV / MDV',
				'country_code' => '960',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Mali',
				'iso_code' => 'ML / MLI',
				'country_code' => '223',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Malta',
				'iso_code' => 'MT / MLT',
				'country_code' => '356',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Marshall Islands',
				'iso_code' => 'MH / MHL',
				'country_code' => '692',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Mauritania',
				'iso_code' => 'MR / MRT',
				'country_code' => '222',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Mauritius',
				'iso_code' => 'MU / MUS',
				'country_code' => '230',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Mayotte',
				'iso_code' => 'YT / MYT',
				'country_code' => '262',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Mexico',
				'iso_code' => 'MX / MEX',
				'country_code' => '52',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Micronesia',
				'iso_code' => 'FM / FSM',
				'country_code' => '691',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Moldova',
				'iso_code' => 'MD / MDA',
				'country_code' => '373',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Monaco',
				'iso_code' => 'MC / MCO',
				'country_code' => '377',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Mongolia',
				'iso_code' => 'MN / MNG',
				'country_code' => '976',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Montenegro',
				'iso_code' => 'ME / MNE',
				'country_code' => '382',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Morocco',
				'iso_code' => 'MA / MAR',
				'country_code' => '212',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Mozambique',
				'iso_code' => 'MZ / MOZ',
				'country_code' => '258',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Namibia',
				'iso_code' => 'NA / NAM',
				'country_code' => '264',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Nauru',
				'iso_code' => 'NR / NRU',
				'country_code' => '674',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Nepal',
				'iso_code' => 'NP / NPL',
				'country_code' => '977',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Netherlands',
				'iso_code' => 'NL / NLD',
				'country_code' => '31',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Netherlands Antilles',
				'iso_code' => 'AN / ANT',
				'country_code' => '599',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'New Caledonia',
				'iso_code' => 'NC / NCL',
				'country_code' => '687',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'New Zealand',
				'iso_code' => 'NZ / NZL',
				'country_code' => '64',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Nicaragua',
				'iso_code' => 'NI / NIC',
				'country_code' => '505',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Niger',
				'iso_code' => 'NE / NER',
				'country_code' => '227',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Nigeria',
				'iso_code' => 'NG / NGA',
				'country_code' => '234',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Niue',
				'iso_code' => 'NU / NIU',
				'country_code' => '683',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Norfolk Island',
				'iso_code' => '/ NFK',
				'country_code' => '672',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'North Korea',
				'iso_code' => 'KP / PRK',
				'country_code' => '850',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Norway',
				'iso_code' => 'NO / NOR',
				'country_code' => '47',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Oman',
				'iso_code' => 'OM / OMN',
				'country_code' => '968',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Pakistan',
				'iso_code' => 'PK / PAK',
				'country_code' => '92',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Palau',
				'iso_code' => 'PW / PLW',
				'country_code' => '680',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Panama',
				'iso_code' => 'PA / PAN',
				'country_code' => '507',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Papua New Guinea',
				'iso_code' => 'PG / PNG',
				'country_code' => '675',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Paraguay',
				'iso_code' => 'PY / PRY',
				'country_code' => '595',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Peru',
				'iso_code' => 'PE / PER',
				'country_code' => '51',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Philippines',
				'iso_code' => 'PH / PHL',
				'country_code' => '63',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Pitcairn Islands',
				'iso_code' => 'PN / PCN',
				'country_code' => '870',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Poland',
				'iso_code' => 'PL / POL',
				'country_code' => '48',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Portugal',
				'iso_code' => 'PT / PRT',
				'country_code' => '351',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Puerto Rico',
				'iso_code' => 'PR / PRI',
				'country_code' => '1',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Qatar',
				'iso_code' => 'QA / QAT',
				'country_code' => '974',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Republic of the Congo',
				'iso_code' => 'CG / COG',
				'country_code' => '242',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Romania',
				'iso_code' => 'RO / ROU',
				'country_code' => '40',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Russia',
				'iso_code' => 'RU / RUS',
				'country_code' => '7',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Rwanda',
				'iso_code' => 'RW / RWA',
				'country_code' => '250',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Saint Barthelemy',
				'iso_code' => 'BL / BLM',
				'country_code' => '590',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Saint Helena',
				'iso_code' => 'SH / SHN',
				'country_code' => '290',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Saint Pierre and Miquelon',
				'iso_code' => 'PM / SPM',
				'country_code' => '508',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Samoa',
				'iso_code' => 'WS / WSM',
				'country_code' => '685',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'San Marino',
				'iso_code' => 'SM / SMR',
				'country_code' => '378',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Sao Tome and Principe',
				'iso_code' => 'ST / STP',
				'country_code' => '239',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Saudi Arabia',
				'iso_code' => 'SA / SAU',
				'country_code' => '966',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Senegal',
				'iso_code' => 'SN / SEN',
				'country_code' => '221',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Serbia',
				'iso_code' => 'RS / SRB',
				'country_code' => '381',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Seychelles',
				'iso_code' => 'SC / SYC',
				'country_code' => '248',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Sierra Leone',
				'iso_code' => 'SL / SLE',
				'country_code' => '232',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Singapore',
				'iso_code' => 'SG / SGP',
				'country_code' => '65',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Slovakia',
				'iso_code' => 'SK / SVK',
				'country_code' => '421',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Slovenia',
				'iso_code' => 'SI / SVN',
				'country_code' => '386',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Solomon Islands',
				'iso_code' => 'SB / SLB',
				'country_code' => '677',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Somalia',
				'iso_code' => 'SO / SOM',
				'country_code' => '252',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'South Africa',
				'iso_code' => 'ZA / ZAF',
				'country_code' => '27',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'South Korea',
				'iso_code' => 'KR / KOR',
				'country_code' => '82',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Spain',
				'iso_code' => 'ES / ESP',
				'country_code' => '34',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Sri Lanka',
				'iso_code' => 'LK / LKA',
				'country_code' => '94',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Sudan',
				'iso_code' => 'SD / SDN',
				'country_code' => '249',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Suriname',
				'iso_code' => 'SR / SUR',
				'country_code' => '597',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Swaziland',
				'iso_code' => 'SZ / SWZ',
				'country_code' => '268',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Sweden',
				'iso_code' => 'SE / SWE',
				'country_code' => '46',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Switzerland',
				'iso_code' => 'CH / CHE',
				'country_code' => '41',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Syria',
				'iso_code' => 'SY / SYR',
				'country_code' => '963',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Taiwan',
				'iso_code' => 'TW / TWN',
				'country_code' => '886',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Tajikistan',
				'iso_code' => 'TJ / TJK',
				'country_code' => '992',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Tanzania',
				'iso_code' => 'TZ / TZA',
				'country_code' => '255',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Thailand',
				'iso_code' => 'TH / THA',
				'country_code' => '66',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Timor-Leste',
				'iso_code' => 'TL / TLS',
				'country_code' => '670',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Togo',
				'iso_code' => 'TG / TGO',
				'country_code' => '228',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Tokelau',
				'iso_code' => 'TK / TKL',
				'country_code' => '690',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Tonga',
				'iso_code' => 'TO / TON',
				'country_code' => '676',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Tunisia',
				'iso_code' => 'TN / TUN',
				'country_code' => '216',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Turkey',
				'iso_code' => 'TR / TUR',
				'country_code' => '90',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Turkmenistan',
				'iso_code' => 'TM / TKM',
				'country_code' => '993',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Tuvalu',
				'iso_code' => 'TV / TUV',
				'country_code' => '688',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Uganda',
				'iso_code' => 'UG / UGA',
				'country_code' => '256',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Ukraine',
				'iso_code' => 'UA / UKR',
				'country_code' => '380',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'United Arab Emirates',
				'iso_code' => 'AE / ARE',
				'country_code' => '971',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'United Kingdom',
				'iso_code' => 'GB / GBR',
				'country_code' => '44',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'United States',
				'iso_code' => 'US / USA',
				'country_code' => '1',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Uruguay',
				'iso_code' => 'UY / URY',
				'country_code' => '598',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Uzbekistan',
				'iso_code' => 'UZ / UZB',
				'country_code' => '998',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Vanuatu',
				'iso_code' => 'VU / VUT',
				'country_code' => '678',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Venezuela',
				'iso_code' => 'VE / VEN',
				'country_code' => '58',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Vietnam',
				'iso_code' => 'VN / VNM',
				'country_code' => '84',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Wallis and Futuna',
				'iso_code' => 'WF / WLF',
				'country_code' => '681',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'West Bank',
				'iso_code' => '/',
				'country_code' => '970',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Yemen',
				'iso_code' => 'YE / YEM',
				'country_code' => '967',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Zambia',
				'iso_code' => 'ZM / ZMB',
				'country_code' => '260',
				'tariff' => '1.00',
				'active' => '1'
			],
			[
				'country_name' => 'Zimbabwe',
				'iso_code' => 'ZW / ZWE',
				'country_code' => '263',
				'tariff' => '1.00',
				'active' => '1'
			]
		];

		foreach ($value as $v){
			IntCountryCodes::create($v);
		}

	}
}
