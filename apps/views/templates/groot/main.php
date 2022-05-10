<?php

$this->template->load('header');

isset($page) ? $this->load->view($page) : null;

$this->template->load('footer');
