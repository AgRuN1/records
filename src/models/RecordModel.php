<?php

namespace models;


class RecordModel extends BaseModel
{
    function __construct(
        private int $authorId,
        private string $text
    )
    {}

    public function getAuthorId(): int
    {
        return $this->authorId;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function toArray(): array
    {
        return [
            'author_id' => $this->getAuthorId(),
            'text' => $this->getText()
        ];
    }

    static public function fromAssoc($data): RecordModel
    {
        return new RecordModel(
            $data['author_id'],
            $data['text']
        );
    }
}