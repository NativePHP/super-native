@php
    use App\Icons\Ios;
    use App\Icons\Android;
@endphp


<list @refresh="refresh" :separator="true" class="w-full h-full ">
    @foreach ($emails as $email)
        <list-item
            :native:key="$email['id']"
            @tap="open('{{ $email['id'] }}')"
            :leadingMonogram="strtoupper(substr($email['from'], 0, 1))"
            :leadingMonogramColor="$email['unread'] ? '#3B82F6' : '#94A3B8'"
            :overline="$email['from']"
            :headline="$email['subject']"
            :supporting="$email['preview']"
            :trailing-badges="array_values(array_filter([
                $email['flagged'] ? [
                    'ios'     => Ios::FlagFill,
                    'android' => Android::Flag,
                    'color'   => '#EF4444',
                ] : null,
                $email['pinned'] ? [
                    'ios'     => 'pin.fill',
                    'android' => Android::PushPin,
                    'color'   => '#F59E0B',
                ] : null,
            ]))"
            :leading-actions="[
                [
                    'method'  => $email['unread'] ? 'open(\'' . $email['id'] . '\')' : 'toggleRead(\'' . $email['id'] . '\')',
                    'label'   => $email['unread'] ? 'Read' : 'Unread',
                    'ios'     => $email['unread'] ? Ios::Envelope : Ios::EnvelopeFill,
                    'android' => Android::MarkEmailRead,
                    'tint'    => '#3B82F6',
                ],
                [
                    'method'  => 'togglePin(\'' . $email['id'] . '\')',
                    'label'   => $email['pinned'] ? 'Unpin' : 'Pin',
                    'ios'     => 'pin.fill',
                    'android' => Android::PushPin,
                    'tint'    => $email['pinned'] ? '#D97706' : '#F59E0B',
                ],
            ]"
            :trailing-actions="[
                [
                    'method'  => 'toggleFlag(\'' . $email['id'] . '\')',
                    'label'   => $email['flagged'] ? 'Unflag' : 'Flag',
                    'ios'     => Ios::Flag,
                    'android' => Android::Flag,
                    'tint'    => $email['flagged'] ? '#EA580C' : '#F97316',
                ],
                [
                    'method'  => 'delete(\'' . $email['id'] . '\')',
                    'label'   => 'Delete',
                    'ios'     => Ios::Trash,
                    'android' => Android::Delete,
                    'role'    => 'destructive',
                ],
            ]" />
    @endforeach

    @if (empty($emails))
        <column class="w-full items-center justify-center py-20 gap-2">
            <text class="text-base font-semibold text-theme-on-surface">All clean</text>
            <text class="text-sm text-theme-on-surface-variant">Pull down to refresh.</text>
        </column>
    @endif

</list>
