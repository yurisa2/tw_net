<?php


class Markov  {

    public function generateMarkovChainsWords($sInput) {
      global $file_db; //temp

        $lStart = microtime(TRUE);
        $aWords = str_word_count($sInput, 1, '\'"-,.;:0123456789%?!');

        var_dump($aWords);

        $file_db->beginTransaction();
        $insert = "insert into mkv_words ('mkv_seq','next_word','set') VALUES ";

        $insert_values = NULL;

        foreach ($aWords as $i => $sWord) {
            if (!empty($aWords[$i + 2])) {
                $aMarkovChains[$sWord . ' ' . $aWords[$i + 1]][] = $aWords[$i + 2];

                $insert_values .= "('".$sWord . ' ' . $aWords[$i + 1]."', '".$aWords[$i + 2]."', 'TESTE'),";
            }
        }

        $insert_values = substr_replace($insert_values ,"", -1);
        $stmt = $file_db->prepare($insert.$insert_values);
        $stmt->execute();
        $file_db->commit();
        printf("- done, generated %d chains in %.3f seconds\n\n", count($aMarkovChains), microtime(TRUE) - $lStart);

        var_dump($aMarkovChains);

        return $aMarkovChains;
    }

}
?>
