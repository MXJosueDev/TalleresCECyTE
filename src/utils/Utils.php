<?php

namespace MXJosueDev\TalleresCecyte\utils;

use DateTimeImmutable;

class Utils
{
    public static function getPart(array &$full, $length): string
    {
        $result = array_splice($full, 0, $length);

        return implode($result);
    }

    public static function normalizeText(string $text): string
    {
        return preg_replace("/\s+/", " ", trim($text));
    }

    /**
     * @param \DateTimeImmutable $from
     * @param \DateTimeImmutable $to
     * @return DateTimeImmutable[]
     */
    public static function findWorkshopDays(DateTimeImmutable $from, DateTimeImmutable $to, int $dayOfWeek): array
    {
        if ($from > $to) {
            return [];
        }

        $currentDay = (int) $from->format("N");

        if ($currentDay < $dayOfWeek) {
            $from = $from->modify("+" . ($dayOfWeek - $currentDay) . " days");
        } else if ($currentDay > $dayOfWeek) {
            $from = $from->modify("+" . (7 - $currentDay + $dayOfWeek) . " days");
        }

        do {
            $result[] = $from;
            $from = $from->modify('+7 days');
        } while ($from < $to);

        return $result ?? [];
    }
}
