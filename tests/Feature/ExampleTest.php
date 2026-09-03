<?php

test('usuário não autenticado é redirecionado para o login', function () {

    $response = $this->get('/home');

    $response->assertRedirect('/login');

});