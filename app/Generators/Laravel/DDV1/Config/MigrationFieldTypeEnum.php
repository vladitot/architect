<?php

namespace App\Generators\Laravel\DDV1\Config;

enum MigrationFieldTypeEnum: string
{
    case addFluentIndexes = 'addFluentIndexes';
    case id = 'id';
    case increments = 'increments';
    case integerIncrements = 'integerIncrements';
    case tinyIncrements = 'tinyIncrements';
    case smallIncrements = 'smallIncrements';
    case mediumIncrements = 'mediumIncrements';
    case bigIncrements = 'bigIncrements';
    case char = 'char';
    case string = 'string';
    case tinyText = 'tinyText';
    case text = 'text';
    case mediumText = 'mediumText';
    case longText = 'longText';
    case integer = 'integer';
    case tinyInteger = 'tinyInteger';
    case smallInteger = 'smallInteger';
    case mediumInteger = 'mediumInteger';
    case bigInteger = 'bigInteger';
    case unsignedInteger = 'unsignedInteger';
    case unsignedTinyInteger = 'unsignedTinyInteger';
    case unsignedSmallInteger = 'unsignedSmallInteger';
    case unsignedMediumInteger = 'unsignedMediumInteger';
    case unsignedBigInteger = 'unsignedBigInteger';
    case foreignId = 'foreignId';
    case float = 'float';
    case double = 'double';
    case decimal = 'decimal';
    case unsignedFloat = 'unsignedFloat';
    case unsignedDouble = 'unsignedDouble';
    case unsignedDecimal = 'unsignedDecimal';
    case boolean = 'boolean';
    case enum = 'enum';
    case set = 'set';
    case json = 'json';
    case jsonb = 'jsonb';
    case date = 'date';
    case dateTime = 'dateTime';
    case dateTimeTz = 'dateTimeTz';
    case time = 'time';
    case timeTz = 'timeTz';
    case timestamp = 'timestamp';
    case timestampTz = 'timestampTz';
    case softDeletes = 'softDeletes';
    case softDeletesTz = 'softDeletesTz';
    case year = 'year';
    case binary = 'binary';
    case uuid = 'uuid';
    case ipAddress = 'ipAddress';
    case macAddress = 'macAddress';
    case geometry = 'geometry';
    case point = 'point';
    case lineString = 'lineString';
    case polygon = 'polygon';
    case geometryCollection = 'geometryCollection';
    case multiPoint = 'multiPoint';
    case multiLineString = 'multiLineString';
    case multiPolygon = 'multiPolygon';
    case multiPolygonZ = 'multiPolygonZ';
    case rememberToken = 'rememberToken';
}
