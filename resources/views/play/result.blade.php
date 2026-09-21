<?php
@if ($submission->status === 'pending')
    <p>Je antwoord is ingeleverd en wacht op beoordeling door de organisatie.</p>
@elseif ($submission->status === 'correct')
    <p>Goed! +{{ $submission->points_awarded }} punten.</p>
@else
    <p>Helaas, dat was niet het juiste antwoord.</p>
@endif

@if ($submission->feedback)
    <blockquote>{{ $submission->feedback }}</blockquote>
@endif
