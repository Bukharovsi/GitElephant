    const MODE_RENAMED      = 'renamed_file';
    /**
     * rename similarity index
     *
     * @var int
     */
    private $similarityIndex;


        $sliceIndex = 4;
        if ($this->hasPathChanged()) {
            $this->findSimilarityIndex($lines[1]);
            if (isset($lines[4]) && !empty($lines[4])) {
                $this->findMode($lines[4]);
                $sliceIndex = 7;
            } else {
                $this->mode = self::MODE_RENAMED;
            }
        } else {
            $this->findMode($lines[1]);
        }
            $lines = array_slice($lines, $sliceIndex);
    /**
     * look for similarity index in the line
     *
     * @param string $line line content
     */
    private function findSimilarityIndex($line)
    {
        $matches = array();
        if (preg_match('/^similarity index (.*)\%$/', $line, $matches)) {
            $this->similarityIndex = $matches[1];
        }
    }

    /**
     * Check if path has changed (file was renamed)
     *
     * @return bool
     */
    public function hasPathChanged()
    {
        return ($this->originalPath !== $this->destinationPath);
    }

    /**
     * Get similarity index
     *
     * @return int
     * @throws \RuntimeException if not a rename
     */
    public function getSimilarityIndex()
    {
        if ($this->hasPathChanged()) {
            return $this->similarityIndex;
        }

        throw new \RuntimeException('Cannot get similiarity index on non-renames');
    }