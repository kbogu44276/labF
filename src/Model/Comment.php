<?php

namespace App\Model;

use App\Service\Config;

class Comment
{
    private ?int $id = null;
    private ?string $author = null;
    private ?string $content = null;

    public function getId(): ?int { return $this->id; }
    public function setId(?int $id): self { $this->id = $id; return $this; }

    public function getAuthor(): ?string { return $this->author; }
    public function setAuthor(?string $author): self { $this->author = $author; return $this; }

    public function getContent(): ?string { return $this->content; }
    public function setContent(?string $content): self { $this->content = $content; return $this; }

    public static function fromArray(array $array): self
    {
        $comment = new self();
        return $comment->fill($array);
    }

    public function fill(array $array): self
    {
        if (isset($array['id']) && !$this->getId()) {
            $this->setId((int)$array['id']);
        }
        if (isset($array['author'])) {
            $this->setAuthor($array['author']);
        }
        if (isset($array['content'])) {
            $this->setContent($array['content']);
        }
        return $this;
    }

    public static function findAll(): array
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT * FROM comment ORDER BY id DESC';
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $rows = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        $comments = [];
        foreach ($rows as $row) {
            $comments[] = self::fromArray($row);
        }
        return $comments;
    }

    public static function find(int $id): ?self
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = 'SELECT * FROM comment WHERE id = :id';
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        if (!$row) return null;

        return self::fromArray($row);
    }

    public function save(): void
    {
        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));

        if (!$this->getId()) {
            $sql = "INSERT INTO comment (author, content) VALUES (:author, :content)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'author' => $this->getAuthor(),
                'content' => $this->getContent(),
            ]);
            $this->setId((int)$pdo->lastInsertId());
        } else {
            $sql = "UPDATE comment SET author = :author, content = :content WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                'author' => $this->getAuthor(),
                'content' => $this->getContent(),
                'id' => $this->getId(),
            ]);
        }
    }

    public function delete(): void
    {
        if (!$this->getId()) return;

        $pdo = new \PDO(Config::get('db_dsn'), Config::get('db_user'), Config::get('db_pass'));
        $sql = "DELETE FROM comment WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $this->getId()]);

        $this->setId(null)->setAuthor(null)->setContent(null);
    }
}
