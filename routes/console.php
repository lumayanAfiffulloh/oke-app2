<?php

use Illuminate\Console\Scheduling\Schedule;

app(Schedule::class)->command('check:deadlines')->everyMinute();
