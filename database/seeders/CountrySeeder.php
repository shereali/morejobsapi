<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Country;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class CountrySeeder extends Seeder
{

    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Country::truncate();
        Schema::enableForeignKeyConstraints();

        $data = [
            ['title' => 'Bangladesh'],
            ['title' => 'Afghanistan'],
            ['title' => 'Åland Islands'],
            ['title' => 'Albania'],
            ['title' => 'Algeria'],
            ['title' => 'American Samoa'],
            ['title' => 'AndorrA'],
            ['title' => 'Angola'],
            ['title' => 'Anguilla'],
            ['title' => 'Antarctica'],
            ['title' => 'Antigua and Barbuda'],
            ['title' => 'Argentina'],
            ['title' => 'Armenia'],
            ['title' => 'Aruba'],
            ['title' => 'Australia'],
            ['title' => 'Austria'],
            ['title' => 'Azerbaijan'],
            ['title' => 'Bahamas'],
            ['title' => 'Bahrain'],
            ['title' => 'Barbados'],
            ['title' => 'Belarus'],
            ['title' => 'Belgium'],
            ['title' => 'Belize'],
            ['title' => 'Benin'],
            ['title' => 'Bermuda'],
            ['title' => 'Bhutan'],
            ['title' => 'Bolivia'],
            ['title' => 'Bosnia and Herzegovina'],
            ['title' => 'Botswana'],
            ['title' => 'Bouvet Island'],
            ['title' => 'Brazil'],
            ['title' => 'British Indian Ocean Territory'],
            ['title' => 'Brunei Darussalam'],
            ['title' => 'Bulgaria'],
            ['title' => 'Burkina Faso'],
            ['title' => 'Burundi'],
            ['title' => 'Cambodia'],
            ['title' => 'Cameroon'],
            ['title' => 'Canada'],
            ['title' => 'Cape Verde'],
            ['title' => 'Cayman Islands'],
            ['title' => 'Central African Republic'],
            ['title' => 'Chad'],
            ['title' => 'Chile'],
            ['title' => 'China'],
            ['title' => 'Christmas Island'],
            ['title' => 'Cocos (Keeling) Islands'],
            ['title' => 'Colombia'],
            ['title' => 'Comoros'],
            ['title' => 'Congo'],
            ['title' => 'Congo, The Democratic Republic of the'],
            ['title' => 'Cook Islands'],
            ['title' => 'Costa Rica'],
            ['title' => 'Croatia'],
            ['title' => 'Cuba'],
            ['title' => 'Cyprus'],
            ['title' => 'Czech Republic'],
            ['title' => 'Denmark'],
            ['title' => 'Djibouti'],
            ['title' => 'Dominica'],
            ['title' => 'Dominican Republic'],
            ['title' => 'Ecuador'],
            ['title' => 'Egypt'],
            ['title' => 'El Salvador'],
            ['title' => 'Equatorial Guinea'],
            ['title' => 'Eritrea'],
            ['title' => 'Estonia'],
            ['title' => 'Ethiopia'],
            ['title' => 'Falkland Islands (Malvinas)'],
            ['title' => 'Faroe Islands'],
            ['title' => 'Fiji'],
            ['title' => 'Finland'],
            ['title' => 'France'],
            ['title' => 'French Guiana'],
            ['title' => 'French Polynesia'],
            ['title' => 'French Southern Territories'],
            ['title' => 'Gabon'],
            ['title' => 'Gambia'],
            ['title' => 'Georgia'],
            ['title' => 'Germany'],
            ['title' => 'Ghana'],
            ['title' => 'Gibraltar'],
            ['title' => 'Greece'],
            ['title' => 'Greenland'],
            ['title' => 'Grenada'],
            ['title' => 'Guadeloupe'],
            ['title' => 'Guam'],
            ['title' => 'Guatemala'],
            ['title' => 'Guernsey'],
            ['title' => 'Guinea'],
            ['title' => 'Guinea-Bissau'],
            ['title' => 'Guyana'],
            ['title' => 'Haiti'],
            ['title' => 'Heard Island and Mcdonald Islands'],
            ['title' => 'Holy See (Vatican City State)'],
            ['title' => 'Honduras'],
            ['title' => 'Hong Kong'],
            ['title' => 'Hungary'],
            ['title' => 'Iceland'],
            ['title' => 'India'],
            ['title' => 'Indonesia'],
            ['title' => 'Iran, Islamic Republic Of'],
            ['title' => 'Iraq'],
            ['title' => 'Ireland'],
            ['title' => 'Isle of Man'],
            ['title' => 'Israel'],
            ['title' => 'Italy'],
            ['title' => 'Jamaica'],
            ['title' => 'Japan'],
            ['title' => 'Jersey'],
            ['title' => 'Jordan'],
            ['title' => 'Kazakhstan'],
            ['title' => 'Kenya'],
            ['title' => 'Kiribati'],
            ['title' => 'Korea, Republic of'],
            ['title' => 'Kuwait'],
            ['title' => 'Kyrgyzstan'],
            ['title' => 'Latvia'],
            ['title' => 'Lebanon'],
            ['title' => 'Lesotho'],
            ['title' => 'Liberia'],
            ['title' => 'Libyan Arab Jamahiriya'],
            ['title' => 'Liechtenstein'],
            ['title' => 'Lithuania'],
            ['title' => 'Luxembourg'],
            ['title' => 'Macao'],
            ['title' => 'Macedonia, The Former Yugoslav Republic of'],
            ['title' => 'Madagascar'],
            ['title' => 'Malawi'],
            ['title' => 'Malaysia'],
            ['title' => 'Maldives'],
            ['title' => 'Mali'],
            ['title' => 'Malta'],
            ['title' => 'Marshall Islands'],
            ['title' => 'Martinique'],
            ['title' => 'Mauritania'],
            ['title' => 'Mauritius'],
            ['title' => 'Mayotte'],
            ['title' => 'Mexico'],
            ['title' => 'Micronesia, Federated States of'],
            ['title' => 'Moldova, Republic of'],
            ['title' => 'Monaco'],
            ['title' => 'Mongolia'],
            ['title' => 'Montserrat'],
            ['title' => 'Morocco'],
            ['title' => 'Mozambique'],
            ['title' => 'Myanmar'],
            ['title' => 'Namibia'],
            ['title' => 'Nauru'],
            ['title' => 'Nepal'],
            ['title' => 'Netherlands'],
            ['title' => 'Netherlands Antilles'],
            ['title' => 'New Caledonia'],
            ['title' => 'New Zealand'],
            ['title' => 'Nicaragua'],
            ['title' => 'Niger'],
            ['title' => 'Nigeria'],
            ['title' => 'Niue'],
            ['title' => 'Norfolk Island'],
            ['title' => 'Northern Mariana Islands'],
            ['title' => 'Norway'],
            ['title' => 'Oman'],
            ['title' => 'Pakistan'],
            ['title' => 'Palau'],
            ['title' => 'Palestinian Territory, Occupied'],
            ['title' => 'Panama'],
            ['title' => 'Papua New Guinea'],
            ['title' => 'Paraguay'],
            ['title' => 'Peru'],
            ['title' => 'Philippines'],
            ['title' => 'Pitcairn'],
            ['title' => 'Poland'],
            ['title' => 'Portugal'],
            ['title' => 'Puerto Rico'],
            ['title' => 'Qatar'],
            ['title' => 'Reunion'],
            ['title' => 'Romania'],
            ['title' => 'Russian Federation'],
            ['title' => 'RWANDA'],
            ['title' => 'Saint Helena'],
            ['title' => 'Saint Kitts and Nevis'],
            ['title' => 'Saint Lucia'],
            ['title' => 'Saint Pierre and Miquelon'],
            ['title' => 'Saint Vincent and the Grenadines'],
            ['title' => 'Samoa'],
            ['title' => 'San Marino'],
            ['title' => 'Sao Tome and Principe'],
            ['title' => 'Saudi Arabia'],
            ['title' => 'Senegal'],
            ['title' => 'Serbia and Montenegro'],
            ['title' => 'Seychelles'],
            ['title' => 'Sierra Leone'],
            ['title' => 'Singapore'],
            ['title' => 'Slovakia'],
            ['title' => 'Slovenia'],
            ['title' => 'Solomon Islands'],
            ['title' => 'Somalia'],
            ['title' => 'South Africa'],
            ['title' => 'South Georgia and the South Sandwich Islands'],
            ['title' => 'Spain'],
            ['title' => 'Sri Lanka'],
            ['title' => 'Sudan'],
            ['title' => 'Suriname'],
            ['title' => 'Svalbard and Jan Mayen'],
            ['title' => 'Swaziland'],
            ['title' => 'Sweden'],
            ['title' => 'Switzerland'],
            ['title' => 'Syrian Arab Republic'],
            ['title' => 'Taiwan, Province of China'],
            ['title' => 'Tajikistan'],
            ['title' => 'Tanzania, United Republic of'],
            ['title' => 'Thailand'],
            ['title' => 'Timor-Leste'],
            ['title' => 'Togo'],
            ['title' => 'Tokelau'],
            ['title' => 'Tonga'],
            ['title' => 'Trinidad and Tobago'],
            ['title' => 'Tunisia'],
            ['title' => 'Turkey'],
            ['title' => 'Turkmenistan'],
            ['title' => 'Turks and Caicos Islands'],
            ['title' => 'Tuvalu'],
            ['title' => 'Uganda'],
            ['title' => 'Ukraine'],
            ['title' => 'United Arab Emirates'],
            ['title' => 'United Kingdom'],
            ['title' => 'United States'],
            ['title' => 'United States Minor Outlying Islands'],
            ['title' => 'Uruguay'],
            ['title' => 'Uzbekistan'],
            ['title' => 'Vanuatu'],
            ['title' => 'Venezuela'],
            ['title' => 'Viet Nam'],
            ['title' => 'Virgin Islands, British'],
            ['title' => 'Virgin Islands, U.S.'],
            ['title' => 'Wallis and Futuna'],
            ['title' => 'Western Sahara'],
            ['title' => 'Yemen'],
            ['title' => 'Zambia'],
            ['title' => 'Zimbabwe']
        ];


        Country::insert($data);
    }
}