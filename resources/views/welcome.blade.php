
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Include jQuery UI -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <!-- Include jQuery UI CSS for styling -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <title>Laravel Calendar App</title>
    <style>
        /* Add your CSS styles here */
        .calendar-container {
            display: flex;
            flex-direction: column;
            max-width: 800px;
            margin: 0 auto;
        }

        .weekdays {
            display: flex;
            justify-content: space-between;
            background-color: #f0f0f0;
            padding: 5px;
            margin-right: 10px;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 5px;
        }

        .day-number {
            font-weight: bold;
        }

        .selected {
            background-color: #7fd7ff;
        }

        .event {
            margin-top: 2px;
            padding: 2px;
            background-color: #cfeeff;
        }
        .pointer {
            cursor: pointer;
        }
    </style>
    @livewireStyles
</head>
<body>
<livewire:calendar />
@livewireScripts
</body>
</html>
