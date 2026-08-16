<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;

class Label extends BaseController
{

    private function findLabelOrRedirect(int $id)
    {
        $labelModel = new \App\Models\LabelModel();
        $label = $labelModel->find($id);

        if (!$label) {
            return redirect()->to('/admin/label')->with('error', 'Etiqueta não encontrada.');
        }

        return $label;
    }

    private function normalizePrinterText(string $value): string
    {
        $value = trim($value);
        $value = str_replace(["\r", "\n", '"'], [' ', ' ', "'"], $value);

        $normalized = @iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $value);
        if ($normalized !== false) {
            $value = $normalized;
        }

        return preg_replace('/\s+/', ' ', $value) ?? $value;
    }

    private function wrapPrinterText(string $value, int $limit): array
    {
        $value = $this->normalizePrinterText($value);
        if ($value === '') {
            return [];
        }

        $lines = wordwrap($value, $limit, "\n", true);

        return array_values(array_filter(array_map('trim', explode("\n", $lines))));
    }

    private function buildPplaTextCommand(string $font, int $y, int $x, string $text): string
    {
        return '1' . $font . '11000' . str_pad((string) $y, 4, '0', STR_PAD_LEFT) . str_pad((string) $x, 4, '0', STR_PAD_LEFT) . $text;
    }

    private function buildPrnContent(array $label): string
    {
        $nameLines = $this->wrapPrinterText((string) ($label['nome'] ?? ''), 28);
        $institutionLines = $this->wrapPrinterText((string) ($label['instituicao'] ?? ''), 34);

        if ($nameLines === []) {
            $nameLines = ['SEM NOME'];
        }

        $commands = [
            "\x02O0220",
            "\x02M3000",
            "\x02e",
            "\x02c0000",
            "\x02f330",
            "\x02L",
            'H13',
            'D11',
            'SE',
            'PD',
            'z',
        ];

        $y = 950;
        foreach (array_slice($nameLines, 0, 2) as $line) {
            $commands[] = $this->buildPplaTextCommand('3', $y, 30, $line);
            $y -= 180;
        }

        $y -= 40;
        foreach (array_slice($institutionLines, 0, 3) as $line) {
            $commands[] = $this->buildPplaTextCommand('2', $y, 30, $line);
            $y -= 150;
        }

        $commands[] = 'Q0001';
        $commands[] = 'E';

        return implode("\r", $commands) . "\r";
    }

    public function index()
    {
        $labelModel = new \App\Models\LabelModel();

        $q = trim((string) $this->request->getGet('q'));

        if ($q !== '') {
            $labelModel
                ->groupStart()
                ->like('nome', $q)
                ->orLike('instituicao', $q)
                ->groupEnd();
        }

        $labels = $labelModel
            ->orderBy('status', 'ASC')
            ->orderBy('nome', 'ASC')
            ->findAll();

        return view('admin/label/index', [
            'labels' => $labels,
            'filters' => [
                'q' => $q,
            ],
        ]);
    }

    public function edit($id)
    {
        $label = $this->findLabelOrRedirect((int) $id);

        if (!$label || !is_array($label)) {
            return $label;
        }

        return view('admin/label/edit', [
            'label' => $label,
        ]);
    }

    public function update($id)
    {
        $label = $this->findLabelOrRedirect((int) $id);

        if (!$label || !is_array($label)) {
            return $label;
        }

        $nome = trim((string) $this->request->getPost('nome'));

        if ($nome === '') {
            return redirect()->back()->withInput()->with('error', 'Informe o nome da etiqueta.');
        }

        $labelModel = new \App\Models\LabelModel();
        $labelModel->update((int) $id, [
            'nome' => $nome,
        ]);

        return redirect()->to('/admin/label')->with('success', 'Nome da etiqueta atualizado com sucesso.');
    }

    public function print($id)
    {
        $label = $this->findLabelOrRedirect((int) $id);

        if (!$label || !is_array($label)) {
            return $label;
        }

        $labelModel = new \App\Models\LabelModel();
        if ((int) ($label['status'] ?? 0) !== 1) {
            $labelModel->update((int) $id, [
                'status' => 1,
            ]);
            $label['status'] = 1;
        }

        $fileName = 'label-' . (int) $label['id_label'] . '.prn';
        $content = $this->buildPrnContent($label);

        return $this->response
            ->setHeader('Content-Type', 'application/octet-stream')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $fileName . '"')
            ->setHeader('Content-Transfer-Encoding', 'binary')
            ->setHeader('Content-Length', (string) strlen($content))
            ->setBody($content);
    }

    public function inport()
    {
        $method = strtoupper($this->request->getMethod());
        if ($method !== 'POST') {
            return view('admin/label/inport');
        }

        $content = trim((string) $this->request->getPost('labels_content'));

        if ($content === '') {
            return redirect()->back()->withInput()->with('error', 'Informe ao menos uma linha no formato Nome;Instituicao.');
        }

        $rows = preg_split('/\r\n|\r|\n/', $content) ?: [];
        $data = [];
        $errorCount = 0;

        foreach ($rows as $row) {
            $row = trim($row);

            if ($row === '') {
                continue;
            }

            $parts = [];

            if (strpos($row, ';') !== false) {
                $parts = explode(';', $row, 2);
            } elseif (preg_match('/\t+/', $row)) {
                $parts = preg_split('/\t+/', $row, 2) ?: [];
            } else {
                $parts = preg_split('/\s{2,}/', $row, 2) ?: [];
            }

            $parts = array_map('trim', $parts);

            if (count($parts) < 2 || $parts[0] === '' || $parts[1] === '') {
                $errorCount++;
                continue;
            }

            $data[] = [
                'nome' => $parts[0],
                'instituicao' => $parts[1],
                'status' => 0,
            ];
        }

        if ($data === []) {
            return redirect()->back()->withInput()->with('error', 'Nenhuma etiqueta valida foi encontrada para importacao. Erros: ' . $errorCount . '.');
        }

        $labelModel = new \App\Models\LabelModel();
        $labelModel->insertBatch($data);

        $message = count($data) . ' etiqueta(s) importada(s). Erros: ' . $errorCount . '.';

        return redirect()->to('/admin/label')->with('success', $message);
    }
}