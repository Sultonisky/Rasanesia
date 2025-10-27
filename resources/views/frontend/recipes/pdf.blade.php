<!DOCTYPE html>
<html>

<head>
    <title>Resep: {{ $recipe->name }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #fff;
            color: #222;
        }
        .pdf-header {
            display: flex;
            align-items: center;
            border-bottom: 2px solid #e74c3c;
            padding-bottom: 10px;
            margin-bottom: 24px;
        }
        .logo {
            width: 48px;
            height: 48px;
            margin-right: 16px;
        }
        .app-title {
            font-size: 1.5em;
            color: #e74c3c;
            font-weight: bold;
        }
        .container {
            width: 90%;
            margin: 0 auto 24px auto;
            background: #fafafa;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.07);
            padding: 32px 24px;
        }
        .header {
            display: flex;
            align-items: center;
            gap: 24px;
            margin-bottom: 24px;
        }
        .foto {
            width: 140px;
            height: 140px;
            object-fit: cover;
            border-radius: 12px;
            border: 2px solid #e74c3c;
        }
        .title {
            font-size: 2.2em;
            color: #e74c3c;
            margin: 0 0 8px 0;
        }
        .meta {
            font-size: 1em;
            color: #555;
            margin-bottom: 4px;
        }
        .author {
            font-size: 1em;
            color: #2980b9;
            margin-bottom: 4px;
        }
        .date {
            font-size: 0.95em;
            color: #888;
            margin-bottom: 4px;
        }
        .rating {
            color: #f1c40f;
            font-size: 1.1em;
            margin-bottom: 8px;
        }
        .stars {
            letter-spacing: 2px;
        }
        h3 {
            color: #e67e22;
            margin-top: 32px;
            margin-bottom: 8px;
        }
        ul, ol {
            margin: 0 0 16px 20px;
        }
        .desc {
            margin-top: 24px;
            font-style: italic;
            color: #444;
        }
        .section {
            margin-bottom: 24px;
        }
        .note {
            background: #f9e79f;
            border-left: 4px solid #f1c40f;
            padding: 10px 16px;
            border-radius: 6px;
            color: #7f6a00;
            margin-top: 16px;
        }
        .footer {
            text-align: center;
            color: #aaa;
            font-size: 0.95em;
            margin-top: 32px;
        }
    </style>
</head>

<body>
    <div class="pdf-header">
        <img src="{{ public_path('assets/img/chef_hat.png') }}" class="logo" alt="Logo">
        <div class="app-title">Rasanesia - Resep Nusantara</div>
    </div>
    <div class="container">
        <div class="header">
            @if($recipe->foto)
                <img src="{{ storage_path('app/public/' . $recipe->foto) }}" class="foto" alt="{{ $recipe->name }}">
            @else
                <img src="{{ public_path('assets/img/chef_hat.png') }}" class="foto" alt="Default">
            @endif
            <div>
                <div class="title">{{ $recipe->name }}</div>
                @if($recipe->province)
                    <div class="meta">Asal: {{ $recipe->province }}</div>
                @endif
                <div class="author">Oleh: {{ $recipe->user->name ?? '-' }}</div>
                <div class="date">Dibuat: {{ $recipe->created_at ? $recipe->created_at->format('d M Y') : '-' }}</div>
                @php
                    $avgRating = $recipe->reviews->avg('rating') ?? 0;
                @endphp
                @if($avgRating > 0)
                    <div class="rating">
                        <span class="stars">
                            @for($i=1; $i<=5; $i++)
                                @if($i <= floor($avgRating))
                                    &#9733;
                                @elseif($i - $avgRating < 1 && $avgRating - floor($avgRating) >= 0.5)
                                    &#9734;
                                @else
                                    &#9734;
                                @endif
                            @endfor
                        </span>
                        ({{ number_format($avgRating, 1) }}/5 dari {{ $recipe->reviews->count() }} ulasan)
                    </div>
                @endif
            </div>
        </div>
        <div class="section">
            <h3>Bahan-bahan:</h3>
            <ul>
                @foreach (explode("\n", $recipe->ingredients) as $ingredient)
                    @if (trim($ingredient))
                        <li>{{ trim($ingredient) }}</li>
                    @endif
                @endforeach
            </ul>
        </div>
        <div class="section">
            <h3>Langkah-langkah:</h3>
            <ol>
                @foreach (explode("\n", $recipe->steps) as $step)
                    @if (trim($step))
                        <li>{{ trim($step) }}</li>
                    @endif
                @endforeach
            </ol>
        </div>
        @if($recipe->description)
            <div class="section">
                <h3>Deskripsi:</h3>
                <div class="desc">{{ $recipe->description }}</div>
            </div>
        @endif
        @if($recipe->note ?? false)
            <div class="note">
                <b>Catatan:</b> {{ $recipe->note }}
            </div>
        @endif
    </div>
    <div class="footer">
        &copy; {{ date('Y') }} Rasanesia | Resep Nusantara | https://rasanesia.com
    </div>
</body>

</html>
