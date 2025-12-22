<?php

test('contact page can be rendered', function () {
    $this->get('/contact')
        ->assertStatus(200)
        ->assertSeeText('Contact');
});

