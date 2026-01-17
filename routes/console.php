<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('statistics:recalculate')
    ->hourly();