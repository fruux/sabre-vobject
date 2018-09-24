<?php

namespace Sabre\VObject\ITip;

class BrokerShareesTest extends BrokerTester {

    function testShareeSendMessage() {

        $oldMessage = <<<ICS
BEGIN:VCALENDAR
VERSION:2.0
BEGIN:VEVENT
UID:foobar
SEQUENCE:1
SUMMARY:foo
ORGANIZER;CN=Strunk:mailto:strunk@example.org
ATTENDEE;CN=Strunk;PARTSTAT=ACCEPTED:mailto:strunk@example.org
ATTENDEE;CN=One:mailto:one@example.org
ATTENDEE;CN=Two:mailto:two@example.org
DTSTART:20140716T120000Z
DTEND:20140716T130000Z
END:VEVENT
END:VCALENDAR
ICS;


        $newMessage = <<<ICS
BEGIN:VCALENDAR
VERSION:2.0
BEGIN:VEVENT
UID:foobar
SEQUENCE:2
SUMMARY:foo
ORGANIZER;CN=Strunk:mailto:strunk@example.org
ATTENDEE;CN=Strunk;PARTSTAT=ACCEPTED:mailto:strunk@example.org
ATTENDEE;CN=Two:mailto:two@example.org
ATTENDEE;CN=Three:mailto:three@example.org
DTSTART:20140716T120000Z
DTEND:20140716T130000Z
END:VEVENT
END:VCALENDAR
ICS;

        $version = \Sabre\VObject\Version::VERSION;

        $expected = [
            [
                'uid'               => 'foobar',
                'method'            => 'REQUEST',
                'component'         => 'VEVENT',
                'sender'            => 'mailto:strunk@example.org',
                'senderName'        => 'Strunk',
                'recipient'         => 'mailto:strunk@example.org',
                'recipientName'     => 'Strunk',
                'significantChange' => false,
                'message'           => <<<ICS
BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//Sabre//Sabre VObject $version//EN
CALSCALE:GREGORIAN
METHOD:REQUEST
BEGIN:VEVENT
UID:foobar
SEQUENCE:2
SUMMARY:foo
ORGANIZER;CN=Strunk:mailto:strunk@example.org
ATTENDEE;CN=Strunk;PARTSTAT=ACCEPTED:mailto:strunk@example.org
ATTENDEE;CN=Two;PARTSTAT=NEEDS-ACTION:mailto:two@example.org
ATTENDEE;CN=Three;PARTSTAT=NEEDS-ACTION:mailto:three@example.org
DTSTART:20140716T120000Z
DTEND:20140716T130000Z
END:VEVENT
END:VCALENDAR
ICS

            ],
            [
                'uid'               => 'foobar',
                'method'            => 'CANCEL',
                'component'         => 'VEVENT',
                'sender'            => 'mailto:strunk@example.org',
                'senderName'        => 'Strunk',
                'recipient'         => 'mailto:one@example.org',
                'recipientName'     => 'One',
                'significantChange' => true,
                'message'           => <<<ICS
BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//Sabre//Sabre VObject $version//EN
CALSCALE:GREGORIAN
METHOD:CANCEL
BEGIN:VEVENT
UID:foobar
DTSTAMP:**ANY**
SEQUENCE:2
SUMMARY:foo
DTSTART:20140716T120000Z
DTEND:20140716T130000Z
ORGANIZER;CN=Strunk:mailto:strunk@example.org
ATTENDEE;CN=One:mailto:one@example.org
END:VEVENT
END:VCALENDAR
ICS

            ],
            [
                'uid'               => 'foobar',
                'method'            => 'REQUEST',
                'component'         => 'VEVENT',
                'sender'            => 'mailto:strunk@example.org',
                'senderName'        => 'Strunk',
                'recipient'         => 'mailto:two@example.org',
                'recipientName'     => 'Two',
                'significantChange' => false,
                'message'           => <<<ICS
BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//Sabre//Sabre VObject $version//EN
CALSCALE:GREGORIAN
METHOD:REQUEST
BEGIN:VEVENT
UID:foobar
SEQUENCE:2
SUMMARY:foo
ORGANIZER;CN=Strunk:mailto:strunk@example.org
ATTENDEE;CN=Strunk;PARTSTAT=ACCEPTED:mailto:strunk@example.org
ATTENDEE;CN=Two;PARTSTAT=NEEDS-ACTION:mailto:two@example.org
ATTENDEE;CN=Three;PARTSTAT=NEEDS-ACTION:mailto:three@example.org
DTSTART:20140716T120000Z
DTEND:20140716T130000Z
END:VEVENT
END:VCALENDAR
ICS

            ],
            [
                'uid'               => 'foobar',
                'method'            => 'REQUEST',
                'component'         => 'VEVENT',
                'sender'            => 'mailto:strunk@example.org',
                'senderName'        => 'Strunk',
                'recipient'         => 'mailto:three@example.org',
                'recipientName'     => 'Three',
                'significantChange' => true,
                'message'           => <<<ICS
BEGIN:VCALENDAR
VERSION:2.0
PRODID:-//Sabre//Sabre VObject $version//EN
CALSCALE:GREGORIAN
METHOD:REQUEST
BEGIN:VEVENT
UID:foobar
SEQUENCE:2
SUMMARY:foo
ORGANIZER;CN=Strunk:mailto:strunk@example.org
ATTENDEE;CN=Strunk;PARTSTAT=ACCEPTED:mailto:strunk@example.org
ATTENDEE;CN=Two;PARTSTAT=NEEDS-ACTION:mailto:two@example.org
ATTENDEE;CN=Three;PARTSTAT=NEEDS-ACTION:mailto:three@example.org
DTSTART:20140716T120000Z
DTEND:20140716T130000Z
END:VEVENT
END:VCALENDAR
ICS

            ],
        ];

        $this->parse($oldMessage, $newMessage, $expected, 'mailto:sharee@example.org', ['mailto:strunk@example.org', 'mailto:sharee@example.org']);

    }

    function testShareeNotSendMessage() {

        $oldMessage = <<<ICS
BEGIN:VCALENDAR
VERSION:2.0
BEGIN:VEVENT
UID:foobar
SEQUENCE:1
SUMMARY:foo
ORGANIZER;CN=Strunk:mailto:strunk@example.org
ATTENDEE;CN=Strunk;PARTSTAT=ACCEPTED:mailto:strunk@example.org
ATTENDEE;CN=One:mailto:one@example.org
ATTENDEE;CN=Two:mailto:two@example.org
DTSTART:20140716T120000Z
DTEND:20140716T130000Z
END:VEVENT
END:VCALENDAR
ICS;


        $newMessage = <<<ICS
BEGIN:VCALENDAR
VERSION:2.0
BEGIN:VEVENT
UID:foobar
SEQUENCE:2
SUMMARY:foo
ORGANIZER;CN=Strunk:mailto:strunk@example.org
ATTENDEE;CN=Strunk;PARTSTAT=ACCEPTED:mailto:strunk@example.org
ATTENDEE;CN=Two:mailto:two@example.org
ATTENDEE;CN=Three:mailto:three@example.org
DTSTART:20140716T120000Z
DTEND:20140716T130000Z
END:VEVENT
END:VCALENDAR
ICS;

        $version = \Sabre\VObject\Version::VERSION;

        $expected = [];

        $this->parse($oldMessage, $newMessage, $expected, 'mailto:notsharee@example.org', ['mailto:strunk@example.org', 'mailto:sharee2@example.org']);

    }
}
