<?php

namespace Foxie\Test;

use Foxie\Request\AccountNumbers;
use Foxie\Request\Balance;
use Foxie\Request\Messages;
use Foxie\Request\NumberLookup;
use Foxie\Request\NumberLookupBulk;

class RequestsTest extends TestCase
{
    public function testBalanceRequest()
    {
        $connectionStub = $this->makeConnection();
        
        $connectionStub->method('request')
                       ->with('GET', '/account/balance')
                       ->will($this->returnValue('{
  "result": {
    "balance": 0
  }
}'));
        
        $expectedResult = [
            'balance' => floatval(0),
        ];
        
        $request = new Balance($connectionStub);
        $result  = $request->send([]);
        
        $this->assertSame($expectedResult, $result->toArray());
    }
    
    public function testAccountNumbersRequest()
    {
        $connectionStub = $this->makeConnection();
        
        $connectionStub->method('request')
                       ->with('GET', '/account/smsnumbers')
                       ->will($this->returnValue('{
  "result": {
        "count": 1,
        "total": 1,
        "smsnumbers": [
            {
                "smsNumber": 15552120001,
                "purchased": "2020-10-13T22:17:33.110Z",
                "campaign": "CCRM1CA"
            }
        ]
    }
}'));
        
        $expectedResult = [
            [
                'smsNumber' => 15552120001,
                'purchased' => new \DateTime('2020-10-13T22:17:33.110Z'),
                'campaign'  => 'CCRM1CA',
            ],
        ];
        
        $request = new AccountNumbers($connectionStub);
        $result  = $request->send([]);
        
        $this->assertCount(1, $result);
        $this->assertEquals($result[0]['smsNumber'], $expectedResult[0]['smsNumber']);
        $this->assertEquals($result[0]['purchased']->getTimestamp(), $expectedResult[0]['purchased']->getTimestamp());
        $this->assertEquals($result[0]['campaign'], $expectedResult[0]['campaign']);
    }
    
    public function testMessagesRequest()
    {
        $connectionStub = $this->makeConnection();
        
        $connectionStub->method('request')
                       ->with('POST', '/messages')
                       ->will($this->returnValue('{
  "result": {
    "id": "FOOBAR",
    "to": 0,
    "from": 0,
    "body": "Message body",
    "balance": 0
  }
}'));
        
        $expectedResult = [
            'id'      => 'FOOBAR',
            'to'      => intval(0),
            'from'    => intval(0),
            'body'    => 'Message body',
            'balance' => floatval(0),
        ];
        
        $request = new Messages($connectionStub);
        $result  = $request->send([
                                      'to'   => 0,
                                      'from' => 0,
                                      'body' => 'Message body',
                                  ]);
        
        $this->assertSame($expectedResult, $result->toArray());
    }
    
    public function testNumberLookupRequest()
    {
        $connectionStub = $this->makeConnection();
        
        $connectionStub->method('request')
                       ->with('GET', '/numberlookup')
                       ->will($this->returnValue('{
  "result": {
    "15552128888": {
      "carrier": "CINGULAR WIRELESS-NSR/2",
      "carrierID": "1025",
      "numberType": "M",
      "valid": true,
      "country": "United States"
    }
  }
}'));
        
        $expectedResult = [
            15552128888 => [
                'number'     => 15552128888,
                'carrier'    => 'CINGULAR WIRELESS-NSR/2',
                'carrierID'  => '1025',
                'numberType' => 'M',
                'valid'      => true,
                'country'    => 'United States',
            ],
        ];
        
        $request = new NumberLookup($connectionStub);
        $result  = $request->send([
                                      'numbers' => [15552128888],
                                  ]);
        
        $this->assertSame($expectedResult, $result->toArray());
    }
    
    public function testNumberLookupBulkRequest()
    {
        $connectionStub = $this->makeConnection();
        
        $connectionStub->method('request')
                       ->with('POST', '/numberlookup/bulk')
                       ->will($this->returnValue('{
  "result": {
    "uuid": "ada8b5a6-1000-4368-8fa8-7ec32a89cb81",
    "status": "queued"
  }
}'));
        
        $expectedResult = [
            'uuid'   => 'ada8b5a6-1000-4368-8fa8-7ec32a89cb81',
            'status' => 'queued',
        ];
        
        $request = new NumberLookupBulk($connectionStub);
        $result  = $request->send([
                                      'numbers'          => [
                                          '15552128888',
                                      ],
                                      'callbackURL'      => 'https://example.com',
                                      'callbackMethod'   => 'POST',
                                      'callbackDataType' => 'data',
                                  ]);
        
        $this->assertSame($expectedResult, $result->toArray());
    }
}