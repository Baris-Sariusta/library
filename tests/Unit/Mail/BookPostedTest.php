<?php

declare(strict_types=1);

use App\Mail\BookPosted;

it('builds the correct fields', function () : void
{
    $mailable = new BookPosted(123, 'My Book');

    expect($mailable)
        ->assertHasSubject('Book Posted')
        ->assertSeeInOrderInHtml(['My Book', '123']);
});
