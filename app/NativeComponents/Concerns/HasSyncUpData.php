<?php

namespace App\NativeComponents\Concerns;

trait HasSyncUpData
{
    /**
     * @return array<int, array{id:int, name:string, avatarUrl:string, status:string, statusText:string}>
     */
    public static function suUsers(): array
    {
        return [
            ['id' => 0, 'name' => 'You',             'avatarUrl' => 'https://i.pravatar.cc/150?u=suelena',  'status' => 'online',  'statusText' => 'Active now'],
            ['id' => 1, 'name' => 'Sarah Miller',    'avatarUrl' => 'https://i.pravatar.cc/150?u=susarah',  'status' => 'online',  'statusText' => 'Active now'],
            ['id' => 2, 'name' => 'David Chen',      'avatarUrl' => 'https://i.pravatar.cc/150?u=sudavid',  'status' => 'offline', 'statusText' => 'Last seen 1h ago'],
            ['id' => 3, 'name' => 'Emma Wilson',     'avatarUrl' => 'https://i.pravatar.cc/150?u=suemma',   'status' => 'offline', 'statusText' => 'Last seen 3h ago'],
            ['id' => 4, 'name' => 'Marcus James',    'avatarUrl' => 'https://i.pravatar.cc/150?u=sumarcus', 'status' => 'away',    'statusText' => 'Away for 10m'],
            ['id' => 5, 'name' => 'Alex Rivera',     'avatarUrl' => 'https://i.pravatar.cc/150?u=sualex',   'status' => 'online',  'statusText' => 'Online'],
            ['id' => 6, 'name' => 'Jordan Lee',      'avatarUrl' => 'https://i.pravatar.cc/150?u=sujordan', 'status' => 'online',  'statusText' => 'Active now'],
            ['id' => 7, 'name' => 'Marcus Chen',     'avatarUrl' => 'https://i.pravatar.cc/150?u=sumchen',  'status' => 'away',    'statusText' => 'Away for 10m'],
            ['id' => 8, 'name' => 'Elena Rodriguez', 'avatarUrl' => 'https://i.pravatar.cc/150?u=suelenar', 'status' => 'online',  'statusText' => 'Active now'],
            ['id' => 9, 'name' => 'Liam Norris',     'avatarUrl' => 'https://i.pravatar.cc/150?u=suliam',   'status' => 'offline', 'statusText' => 'Last seen yesterday'],
        ];
    }

    /**
     * @return array<int, array{id:int, userId:int|null, isGroup:bool, name:string|null, lastMessage:string, lastSenderName:string|null, time:string, unread:int, status:string}>
     *
     * status: 'unread' | 'read' | 'sent'
     */
    public static function suConversations(): array
    {
        return [
            ['id' => 1, 'userId' => 1,    'isGroup' => false, 'name' => null,           'lastMessage' => 'Did you see the new design specs?',     'lastSenderName' => null,    'time' => '2m ago', 'unread' => 2, 'status' => 'unread'],
            ['id' => 2, 'userId' => 2,    'isGroup' => false, 'name' => null,           'lastMessage' => "I'll send the report by EOD tomorrow.", 'lastSenderName' => null,    'time' => '1h ago', 'unread' => 0, 'status' => 'read'],
            ['id' => 3, 'userId' => 3,    'isGroup' => false, 'name' => null,           'lastMessage' => 'The meeting was moved to Friday morning.', 'lastSenderName' => null, 'time' => '3h ago', 'unread' => 0, 'status' => 'sent'],
            ['id' => 4, 'userId' => null, 'isGroup' => true,  'name' => 'Design Team',  'lastMessage' => 'Looks good to me!',                     'lastSenderName' => 'Alex',  'time' => 'Tue',    'unread' => 0, 'status' => 'sent'],
            ['id' => 5, 'userId' => 4,    'isGroup' => false, 'name' => null,           'lastMessage' => 'Thanks for the heads up!',              'lastSenderName' => null,    'time' => 'Mon',    'unread' => 0, 'status' => 'sent'],
        ];
    }

    /**
     * @return array<int, array{id:int, fromMe:bool, text:string, time:string, imageUrl?:string, status?:string}>
     */
    public static function suMessages(int $conversationId): array
    {
        // For the demo every conversation shares the Alex thread. Real impl
        // would key by id. The seed includes one image attachment to exercise
        // the image-bubble case.
        return [
            [
                'id' => 1,
                'fromMe' => false,
                'text' => "Hey! Did you have a chance to look at the SyncUp design system I shared yesterday? I'd love to get your thoughts on the typography scales.",
                'time' => '10:24 AM',
            ],
            [
                'id' => 2,
                'fromMe' => true,
                'text' => 'Just checking it out now! The Plus Jakarta Sans looks incredibly crisp. The spacing rhythm is spot on too.',
                'time' => '10:26 AM',
                'status' => 'read',
            ],
            [
                'id' => 3,
                'fromMe' => false,
                'text' => "Here's a sneak peek of the dashboard layout I'm working on.",
                'time' => '10:28 AM',
                'imageUrl' => 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?w=600',
            ],
            [
                'id' => 4,
                'fromMe' => true,
                'text' => 'That looks incredible! 🚀',
                'time' => '10:30 AM',
                'status' => 'read',
            ],
            [
                'id' => 5,
                'fromMe' => true,
                'text' => 'That looks incredible! 🚀',
                'time' => '10:30 AM',
                'status' => 'read',
            ],
            [
                'id' => 6,
                'fromMe' => true,
                'text' => 'That looks incredible! 🚀',
                'time' => '10:30 AM',
                'status' => 'read',
            ],
            [
                'id' => 7,
                'fromMe' => true,
                'text' => 'That looks incredible! 🚀',
                'time' => '10:30 AM',
                'status' => 'read',
            ],
            [
                'id' => 8,
                'fromMe' => true,
                'text' => 'That looks incredible! 🚀',
                'time' => '10:30 AM',
                'status' => 'read',
            ],
            [
                'id' => 9,
                'fromMe' => true,
                'text' => 'That looks incredible! 🚀',
                'time' => '10:30 AM',
                'status' => 'read',
            ],
        ];
    }

    /**
     * @return array<int, array{id:int, name:string, avatarUrl:string, mutuals:int}>
     */
    public static function suSuggestions(): array
    {
        return [
            ['id' => 100, 'name' => 'Jane Doe',    'avatarUrl' => 'https://i.pravatar.cc/150?u=sujane',     'mutuals' => 4],
            ['id' => 101, 'name' => 'Robert Fox',  'avatarUrl' => 'https://i.pravatar.cc/150?u=surobert',   'mutuals' => 8],
            ['id' => 102, 'name' => 'Liam N.',     'avatarUrl' => 'https://i.pravatar.cc/150?u=suliamn',    'mutuals' => 2],
            ['id' => 103, 'name' => 'Mia Park',    'avatarUrl' => 'https://i.pravatar.cc/150?u=sumia',      'mutuals' => 5],
        ];
    }

    /** @return array<int, string> */
    public static function suFilters(): array
    {
        return ['All', 'Unread', 'Groups', 'Archived'];
    }

    /** Lookup a user by id, with a sensible fallback. */
    public static function suUser(int $id): array
    {
        foreach (self::suUsers() as $u) {
            if ($u['id'] === $id) {
                return $u;
            }
        }
        return self::suUsers()[0];
    }

    /** Lookup a conversation by id. */
    public static function suConversation(int $id): ?array
    {
        foreach (self::suConversations() as $c) {
            if ($c['id'] === $id) {
                return $c;
            }
        }
        return null;
    }
}
