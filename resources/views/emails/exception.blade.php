<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8" />
    <meta name="robots" content="noindex,nofollow" />

    <style>
        body {
            background-color: #F4F6F8;
            color: #222;
            font: 14px/1.5 Helvetica, Arial, sans-serif;
            margin: 0;
            padding-bottom: 40px;
        }

        .container {
            max-width: 1024px;
            margin: 0 auto;
            padding: 0 16px;
        }

        /* ---------- ENV BADGE ---------- */
        .env-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: .5px;
        }

        .env-production {
            background: #B0413E;
            color: #fff;
        }

        .env-staging {
            background: #E6A700;
            color: #000;
        }

        .env-local {
            background: #8b2e64;
            color: #fff;
        }

        /* ---------- HEADER ---------- */
        .exception-summary {
            background: #1F2933;
            color: #fff;
            padding: 24px 0;
            margin-bottom: 24px;
        }

        .exception-message {
            font-size: 22px;
            margin: 10px 0 0;
            word-break: break-word;
        }

        /* ---------- INFO TABLE ---------- */
        table {
            table-layout: fixed;
            width: 100%;
            border-collapse: collapse;
            background: #fff;
            margin-bottom: 24px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, .08);
        }

        th {
            background: #F0F2F4;
            text-align: left;
            padding: 8px 10px;
            font-weight: bold;
            width: 140px;
            white-space: nowrap;
        }

        td {
            width: auto;
            padding: 8px 12px;
        }

        tr:not(:last-child) td,
        tr:not(:last-child) th {
            border-bottom: 1px solid #E5E7EB;
        }

        /* ---------- TRACE ---------- */
        .trace-title {
            font-size: 18px;
            margin: 20px 0 10px;
        }

        .trace-item {
            background: #fff;
            padding: 12px;
            border-left: 4px solid #B0413E;
            margin-bottom: 10px;
            font-family: Consolas, monospace;
            font-size: 13px;
        }

        .muted {
            color: #777;
        }

        .code {
            font-family: Consolas, monospace;
        }
    </style>
</head>

<body>

    @php
        $env = $content['environment'] ?? 'unknown';

        $envClass = match ($env) {
            'production' => 'env-production',
            'staging' => 'env-staging',
            default => 'env-local',
        };

        $url = $content['url'] ?? '';
        $parts = parse_url($url);
        $protocol = $parts['scheme'] ?? null;
        $restUrl = $protocol ? ltrim(str_replace($protocol . '://', '', $url), '/') : $url;
    @endphp

    <!-- ================= HEADER ================= -->
    <div class="exception-summary">
        <div class="container">
            <span class="env-badge {{ $envClass }}">{{ $env }}</span>

            <h1 class="exception-message">
                {{ $content['message'] ?? 'Unhandled Exception' }}
            </h1>

            <p class="muted">
                {{ $content['exception'] ?? '' }}
            </p>
        </div>
    </div>

    <div class="container">

        <!-- ================= REQUEST ================= -->
        <table>
            <tr>
                <th>Protocol</th>
                <td>{{ $protocol ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>URL</th>
                <td class="code">{{ $restUrl }}</td>
            </tr>
            <tr>
                <th>Request Body</th>
                <td>
                    <pre class="code">{{ json_encode($content['body'] ?? [], JSON_PRETTY_PRINT) }}</pre>
                </td>
            </tr>
        </table>

        <!-- ================= EXCEPTION LOCATION ================= -->
        <table>
            <tr>
                <th>File</th>
                <td>{{ $content['file'] ?? '' }}</td>
            </tr>
            <tr>
                <th>Line</th>
                <td>{{ $content['line'] ?? '' }}</td>
            </tr>
        </table>

        <!-- ================= META ================= -->
        <table>
            @if (isset($content['error_id']))
                <tr>
                    <th>Error ID</th>
                    <td>{{ $content['error_id'] ?? 'N/A' }}</td>
                </tr>
            @endif
            @if (!empty($content['occurred_at']))
                <tr>
                    <th>Occurred At ({{ config('app.timezone') }})</th>
                    <td>
                        {{ \Carbon\Carbon::parse($content['occurred_at'])->setTimezone(config('app.timezone'))->format('d M Y, h:i:s A') }}
                    </td>
                </tr>
            @endif
            <tr>
                <th>IP Address</th>
                <td>{{ $content['ip'] ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th>User ID</th>
                <td>{{ $content['context']['user_id'] ?? 'Guest' }}</td>
            </tr>
        </table>

        <!-- ================= TRACE ================= -->
        <h3 class="trace-title">Stack Trace</h3>

        @foreach ($content['trace'] ?? [] as $trace)
            <div class="trace-item">
                <div>
                    {{ $trace['class'] ?? '' }} → <strong>{{ $trace['function'] ?? '' }}</strong>()
                </div>
                <div class="muted">
                    {{ $trace['file'] ?? '' }} : {{ $trace['line'] ?? '' }}
                </div>
            </div>
        @endforeach

    </div>
</body>

</html>
