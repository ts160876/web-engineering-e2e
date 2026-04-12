<?php

/**
 * Lecture Web Engineering
 */

namespace Bukubuku\Models;

use Bukubuku\Core\DatabaseModel;
use Bukubuku\Core\Rule;
use Bukubuku\Core\RuleParameter;

/**
 * Implements the model for the book.
 */
class Book extends DatabaseModel
{
    //Properties of the model
    public int $bookId = 0;
    public string $title = '';
    public string $author = '';
    public string $isbn = '';
    public ?\DateTime $published = null;
    public int $pages = 0;
    public string $format = '';
    //Per default the book is available.
    public string $checkoutStatus = 'available';

    //Get database table.
    static protected function getTableName(): string
    {
        return 'books';
    }

    //Get the primary key of the database table.
    static protected function getPrimaryKeyName(): string
    {
        return 'book_id';
    }

    //Get the mapping column=>property.
    static protected function columnMapping(): array
    {
        return [
            'book_id' => 'bookId',
            'title' => 'title',
            'author' => 'author',
            'isbn' => 'isbn',
            'published' => 'published',
            'pages' => 'pages',
            'format' => 'format',
            'checkout_status' => 'checkoutStatus'
        ];
    }

    //Get the rulesets.
    static protected function getRulesets(): array
    {
        return [
            'title' => [
                Rule::REQUIRED => [],
                Rule::MAX_LENGTH => [RuleParameter::MAX => 100]
            ],
            'author' => [
                Rule::REQUIRED => [],
                Rule::MAX_LENGTH => [RuleParameter::MAX => 100]
            ],
            'isbn' => [
                Rule::REQUIRED => [],
                Rule::MAX_LENGTH => [RuleParameter::MAX => 100],
                Rule::ISBN => []
            ],
            'published' => [
                Rule::REQUIRED => [],
            ],
            'pages' => [
                Rule::REQUIRED => [],
            ],
            'format' => [
                Rule::REQUIRED => [],
                Rule::OPTIONS => [RuleParameter::OPTIONS => ['audio_book', 'hardcover', 'kindle', 'mp3']]
            ],
            'checkoutStatus' => [
                Rule::REQUIRED => [],
                Rule::OPTIONS => [RuleParameter::OPTIONS => ['available', 'checked_out']]
            ]
        ];
    }

    //Get the mapping property=>label.
    static protected function propertyMapping(): array
    {
        return [
            'bookId' => 'Book ID',
            'title' => 'Title',
            'author' => 'Author',
            'isbn' => 'ISBN',
            'published' => 'Published on',
            'pages' => 'Number of Pages',
            'format' => 'Format',
            'checkoutStatus' => 'Checkout Status'
        ];
    }

    //Get dropdown values for checkoutStatus.
    static public function getCheckoutStatusDropdown(): array
    {
        return [
            'available' => 'Available',
            'checked_out' => 'Checked out'
        ];
    }

    //Get text for checkoutStatus.
    static public function getCheckoutStatusText(string $checkoutStatus): string
    {
        $dropdown = static::getCheckoutStatusDropdown();
        return $dropdown[$checkoutStatus] ?? $checkoutStatus;
    }

    //Get dropdown values for format.
    static public function getFormatDropdown(): array
    {
        return [
            'audio_book' => 'Audio Book',
            'hardcover' => 'Hardcover',
            'kindle' => 'Kindle',
            'mp3' => 'MP3'
        ];
    }

    //Get text for format.
    static public function getFormatText(string $format): string
    {
        $dropdown = static::getFormatDropdown();
        return $dropdown[$format] ?? $format;
    }
}
