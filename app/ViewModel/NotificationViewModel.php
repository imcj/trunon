<?php
namespace App\ViewModel;

class NotificationViewModel
{
    private $id;
    private $type;
    private $subject;
    private $content;
    private $unread;
    private $createdAt;

    public function __construct(
        $id,
        $type,
        $subject,
        $content,
        $unread,
        $createdAt
    ) {

        $this->id = $id;
        $this->type = $type;
        $this->subject = $subject;
        $this->content = $content;
        $this->unread = $unread;
        $this->createdAt = $createdAt;
    }

    public function id()
    {
        return $this->id;
    }

    public function cssClassType()
    {
        switch ($this->type) {
            case "default":
            default:
                return " glyphicon-globe";
        }

        return "";
    }

    public function subject()
    {
        return $this->subject;
    }

    public function content()
    {
        return $this->content;
    }

    public function createdAt()
    {
        return $this->createdAt;
    }

    public function unreadCssClassActive()
    {
        if ($this->unread) {
            return "active";
        }
        return "";
    }
}
