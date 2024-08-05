<?php

namespace App\Enums;

use Kongulov\Traits\InteractWithEnum;

enum AWSRegion: string
{
    use InteractWithEnum;

    case US_EAST_1 = 'us-east-1'; // N. Virginia
    case US_EAST_2 = 'us-east-2'; // Ohio
    case US_WEST_1 = 'us-west-1'; // N. California
    case US_WEST_2 = 'us-west-2'; // Oregon
    case AF_SOUTH_1 = 'af-south-1'; // Cape Town
    case AP_EAST_1 = 'ap-east-1'; // Hong Kong
    case AP_SOUTH_1 = 'ap-south-1'; // Mumbai
    case AP_SOUTHEAST_1 = 'ap-southeast-1'; // Singapore
    case AP_SOUTHEAST_2 = 'ap-southeast-2'; // Sydney
    case AP_NORTHEAST_1 = 'ap-northeast-1'; // Tokyo
    case AP_NORTHEAST_2 = 'ap-northeast-2'; // Seoul
    case CA_CENTRAL_1 = 'ca-central-1'; // Central
    case EU_CENTRAL_1 = 'eu-central-1'; // Frankfurt
    case EU_WEST_1 = 'eu-west-1'; // Ireland
    case EU_WEST_2 = 'eu-west-2'; // London
    case EU_SOUTH_1 = 'eu-south-1'; // Milan
    case EU_WEST_3 = 'eu-west-3'; // Paris
    case EU_NORTH_1 = 'eu-north-1'; // Stockholm
    case ME_SOUTH_1 = 'me-south-1'; // Bahrain
    case SA_EAST_1 = 'sa-east-1'; // Sao Paulo
    case US_GOV_EAST_1 = 'us-gov-east-1'; // US Gov East
    case US_GOV_WEST_1 = 'us-gov-west-1'; // US Gov West

    public static function getRegionNames(): array
    {
        return [
            self::US_EAST_1->value => 'N. Virginia',
            self::US_EAST_2->value => 'Ohio',
            self::US_WEST_1->value => 'N. California',
            self::US_WEST_2->value => 'Oregon',
            self::AF_SOUTH_1->value => 'Cape Town',
            self::AP_EAST_1->value => 'Hong Kong',
            self::AP_SOUTH_1->value => 'Mumbai',
            self::AP_SOUTHEAST_1->value => 'Singapore',
            self::AP_SOUTHEAST_2->value => 'Sydney',
            self::AP_NORTHEAST_1->value => 'Tokyo',
            self::AP_NORTHEAST_2->value => 'Seoul',
            self::CA_CENTRAL_1->value => 'Central',
            self::EU_CENTRAL_1->value => 'Frankfurt',
            self::EU_WEST_1->value => 'Ireland',
            self::EU_WEST_2->value => 'London',
            self::EU_SOUTH_1->value => 'Milan',
            self::EU_WEST_3->value => 'Paris',
            self::EU_NORTH_1->value => 'Stockholm',
            self::ME_SOUTH_1->value => 'Bahrain',
            self::SA_EAST_1->value => 'Sao Paulo',
            self::US_GOV_EAST_1->value => 'US Gov East',
            self::US_GOV_WEST_1->value => 'US Gov West',
        ];
    }
}
