<?php
class Example
{
    private $givenArray = [-1, 1, 3, 3, 3, 2, 3, 2, 1, 0, -1];
    private $tilts = [];
    private $result = [];
    private function findTilts()
    {
        for ($i=1;$i<=$this->getSpaceCount();$i++) {
            $this->tilts[$i] = $this->findTilt($this->givenArray[$i-1], $this->givenArray[$i]);
        }
    }

    private function findTilt($value1, $value2)
    {
        $diff = $value2 - $value1;
        if ($diff != 0) {
            $tilt = 1 / $diff;
            return $tilt;
        } else {
            return 1;
        }
    }

    public function getSpaceCount()
    {
        return count($this->givenArray) -1;
    }

    public function solve()
    {
        $this->findTilts();

        for ($i=1;$i<$this->getSpaceCount();$i++) {
            $start = $i;
            while ($this->tilts[$i]==$this->tilts[$i+1]) {
                $i++;
            }
            $finish = $i;
            if ($start==$finish) {
                continue;
            }
            if (($finish - $start-1) > 0) {
                $this->sliceResult($start-1, $finish, $this->result);
            } else {
                $this->result[] = [($start-1) ,$finish];
            }
        }
    }

    private function sliceResult($start, $finish, &$result)
    {
        $sliceResult = $this->_sliceResult(range($start, $finish), 2, 2);
        $result = array_merge($result, $sliceResult);
    }

    private function _sliceResult($in, $minLength = 1, $maxLength = PHP_INT_SIZE)
    {
        $count = count($in);
        $members = pow(2, $count);
        $return = [];
        for ($i = 0; $i < $members; $i++) {
            $b = sprintf("%0" . $count . "b", $i);
            $out = [];
            for ($j = 0; $j < $count; $j++) {
                if ($b{$j} == '1') {
                    $out[] = $in[$j];
                }
            }
            if (count($out) >= $minLength && count($out)<= $maxLength && ($out[1]-$out[0])>1) {
                $return[] = $out;
            }
        }

        return $return;
    }

    public function getResult()
    {
        return $this->result;
    }

    public function setArray($givenArray)
    {
        $this->givenArray = $givenArray;
    }
}
