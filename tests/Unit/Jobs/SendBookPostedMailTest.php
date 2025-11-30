<?php

declare(strict_types=1);

use App\Jobs\SendBookPostedMail;
use App\Mail\BookPosted;
use Illuminate\Support\Facades\Mail;

it('sends the mail to the mail address with the correct fields', function () : void
{
    Mail::fake();

    $job = new SendBookPostedMail(
        userMail: 'test@example.com',
        bookId: '123',
        bookTitle: 'My Book'
    );

    $job->handle();

    Mail::assertSent(BookPosted::class, function (BookPosted $mail) : bool
    {
        return $mail->assertHasTo('test@example.com')
            && $mail->assertHasSubject('Book Posted')
            && $mail->assertSeeInOrderInHtml(['My Book', '123']);
    });
});
