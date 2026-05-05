<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AiWriterController extends Controller
{
    private array $tones = [
        'storytelling' => [
            'label' => 'Storytelling immersif',
            'prompt' => 'Adopte un style de storytelling immersif, humain et inspirant. Écris au présent comme si la scène se déroule maintenant. Utilise des phrases courtes et rythmées. Alterne descriptions simples et images poétiques. Mets en avant les personnes, leurs rôles et émotions. Transforme chaque action en symbole ou en impact. Ajoute occasionnellement des majuscules pour accentuer certains moments. Utilise quelques emojis de manière naturelle (pas excessive). Structure le texte en petites scènes séparées. Termine par une note collective ou de gratitude. Le ton doit être chaleureux, engagé, authentique, jamais trop formel.',
        ],
        'pedagogique' => [
            'label' => 'Pédagogique & clair',
            'prompt' => 'Adopte un style pédagogique, clair et structuré. Explique avec simplicité sans être condescendant. Utilise des exemples concrets et des analogies accessibles. Structure en étapes logiques. Le lecteur doit comprendre immédiatement la valeur de ce qu\'il lit. Ton chaleureux mais professionnel.',
        ],
        'poetique' => [
            'label' => 'Poétique & contemplatif',
            'prompt' => 'Adopte un style poétique, contemplatif et doux. Utilise des métaphores naturelles (eau, lumière, souffle, silence). Phrases courtes, respirées. Crée un espace de calme et de profondeur. Évoque des sensations et des états intérieurs. Idéal pour méditations et contenus bien-être. Pas d\'emojis.',
        ],
        'professionnel' => [
            'label' => 'Professionnel & convaincant',
            'prompt' => 'Adopte un style professionnel, direct et convaincant. Met en avant la valeur, les bénéfices concrets et les résultats. Utilise des formulations actives. Structure claire avec une accroche forte. Termine par un appel à l\'action implicite. Ton confiant et expert.',
        ],
        'conversationnel' => [
            'label' => 'Conversationnel & proche',
            'prompt' => 'Adopte un style conversationnel, proche et authentique. Parle directement au lecteur avec "tu". Pose des questions rhétoriques. Partage des observations du quotidien. Crée un sentiment de proximité et de confiance. Humour léger et bienveillant bienvenu. Naturel comme une conversation entre amis.',
        ],
    ];

    public function generate(Request $request)
    {
        $request->validate([
            'context' => 'required|string|max:500',
            'tone'    => 'required|in:storytelling,pedagogique,poetique,professionnel,conversationnel',
            'type'    => 'required|string|max:100',
        ]);

        $tone = $this->tones[$request->tone];
        $type = $request->type;
        $context = $request->context;

        $systemPrompt = $tone['prompt'] . "\n\nRéponds toujours en français. Ne génère que le texte demandé, sans introduction ni explication.";

        $userPrompt = "Génère un(e) {$type} pour le sujet suivant : {$context}\n\nÉcris directement le contenu, sans titre ni en-tête.";

        $response = Http::withToken(config('services.groq.key'))
            ->post('https://api.groq.com/openai/v1/chat/completions', [
                'model'       => config('services.groq.model', 'llama-3.3-70b-versatile'),
                'messages'    => [
                    ['role' => 'system', 'content' => $systemPrompt],
                    ['role' => 'user',   'content' => $userPrompt],
                ],
                'max_tokens'  => 600,
                'temperature' => 0.8,
            ]);

        if (!$response->successful()) {
            return response()->json(['error' => 'Erreur API Groq : ' . $response->body()], 502);
        }

        $text = $response->json('choices.0.message.content');

        return response()->json(['text' => trim($text)]);
    }

    public function tones()
    {
        return response()->json(array_map(fn($k, $v) => ['value' => $k, 'label' => $v['label']], array_keys($this->tones), $this->tones));
    }
}
