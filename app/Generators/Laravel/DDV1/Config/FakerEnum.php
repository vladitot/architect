<?php

namespace App\Generators\Laravel\DDV1\Config;

enum FakerEnum: string
{
    case citySuffix = 'citySuffix';
    case streetSuffix = 'streetSuffix';
    case buildingNumber = 'buildingNumber';
    case city = 'city';
    case streetName = 'streetName';
    case streetAddress = 'streetAddress';
    case postcode = 'postcode';
    case address = 'address';
    case country = 'country';
    case latitude = 'latitude';
    case longitude = 'longitude';
    case localCoordinates = 'localCoordinates';
    case randomDigitNotNull = 'randomDigitNotNull';
    case passthrough = 'passthrough';
    case randomLetter = 'randomLetter';
    case randomAscii = 'randomAscii';
    case randomElements = 'randomElements';
    case randomElement = 'randomElement';
    case randomKey = 'randomKey';
    case shuffle = 'shuffle';
    case shuffleArray = 'shuffleArray';
    case shuffleString = 'shuffleString';
    case numerify = 'numerify';
    case lexify = 'lexify';
    case bothify = 'bothify';
    case asciify = 'asciify';
    case regexify = 'regexify';
    case toLower = 'toLower';
    case toUpper = 'toUpper';
    case biasedNumberBetween = 'biasedNumberBetween';
    case hexColor = 'hexColor';
    case safeHexColor = 'safeHexColor';
    case rgbColorAsArray = 'rgbColorAsArray';
    case rgbColor = 'rgbColor';
    case rgbCssColor = 'rgbCssColor';
    case rgbaCssColor = 'rgbaCssColor';
    case safeColorName = 'safeColorName';
    case colorName = 'colorName';
    case hslColor = 'hslColor';
    case hslColorAsArray = 'hslColorAsArray';
    case company = 'company';
    case companySuffix = 'companySuffix';
    case jobTitle = 'jobTitle';
    case unixTime = 'unixTime';
    case dateTime = 'dateTime';
    case dateTimeAD = 'dateTimeAD';
    case iso8601 = 'iso8601';
    case date = 'date';
    case time = 'time';
    case dateTimeBetween = 'dateTimeBetween';
    case dateTimeInInterval = 'dateTimeInInterval';
    case dateTimeThisCentury = 'dateTimeThisCentury';
    case dateTimeThisDecade = 'dateTimeThisDecade';
    case dateTimeThisYear = 'dateTimeThisYear';
    case dateTimeThisMonth = 'dateTimeThisMonth';
    case amPm = 'amPm';
    case dayOfMonth = 'dayOfMonth';
    case dayOfWeek = 'dayOfWeek';
    case month = 'month';
    case monthName = 'monthName';
    case year = 'year';
    case century = 'century';
    case timezone = 'timezone';
    case setDefaultTimezone = 'setDefaultTimezone';
    case getDefaultTimezone = 'getDefaultTimezone';
    case file = 'file';
    case randomHtml = 'randomHtml';
    case imageUrl = 'imageUrl';
    case image = 'image';
    case email = 'email';
    case safeEmail = 'safeEmail';
    case freeEmail = 'freeEmail';
    case companyEmail = 'companyEmail';
    case freeEmailDomain = 'freeEmailDomain';
    case safeEmailDomain = 'safeEmailDomain';
    case userName = 'userName';
    case password = 'password';
    case domainName = 'domainName';
    case domainWord = 'domainWord';
    case tld = 'tld';
    case url = 'url';
    case slug = 'slug';
    case ipv4 = 'ipv4';
    case ipv6 = 'ipv6';
    case localIpv4 = 'localIpv4';
    case macAddress = 'macAddress';
    case word = 'word';
    case words = 'words';
    case sentence = 'sentence';
    case sentences = 'sentences';
    case paragraph = 'paragraph';
    case paragraphs = 'paragraphs';
    case text = 'text';
    case boolean = 'boolean';
    case md5 = 'md5';
    case sha1 = 'sha1';
    case sha256 = 'sha256';
    case locale = 'locale';
    case countryCode = 'countryCode';
    case countryISOAlpha3 = 'countryISOAlpha3';
    case languageCode = 'languageCode';
    case currencyCode = 'currencyCode';
    case emoji = 'emoji';
    case creditCardType = 'creditCardType';
    case creditCardNumber = 'creditCardNumber';
    case creditCardExpirationDate = 'creditCardExpirationDate';
    case creditCardExpirationDateString = 'creditCardExpirationDateString';
    case creditCardDetails = 'creditCardDetails';
    case iban = 'iban';
    case swiftBicNumber = 'swiftBicNumber';
    case name = 'name';
    case firstName = 'firstName';
    case firstNameMale = 'firstNameMale';
    case firstNameFemale = 'firstNameFemale';
    case lastName = 'lastName';
    case title = 'title';
    case titleMale = 'titleMale';
    case titleFemale = 'titleFemale';
    case phoneNumber = 'phoneNumber';
    case e164PhoneNumber = 'e164PhoneNumber';
    case imei = 'imei';
    case realText = 'realText';
    case realTextBetween = 'realTextBetween';
    case macProcessor = 'macProcessor';
    case linuxProcessor = 'linuxProcessor';
    case userAgent = 'userAgent';
    case chrome = 'chrome';
    case msedge = 'msedge';
    case firefox = 'firefox';
    case safari = 'safari';
    case opera = 'opera';
    case internetExplorer = 'internetExplorer';
    case windowsPlatformToken = 'windowsPlatformToken';
    case macPlatformToken = 'macPlatformToken';
    case iosMobileToken = 'iosMobileToken';
    case linuxPlatformToken = 'linuxPlatformToken';
    case uuid = 'uuid';
}
